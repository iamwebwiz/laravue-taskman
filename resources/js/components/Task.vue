<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tasks</h4>
                    </div>
                    <div class="card-body">
                        <button @click="initAddTask" class="btn btn-primary btn-block pt-3 pb-3">Add Task</button>
                        <div class="table-responsive mt-5" v-if="tasks.length > 0">
                            <table class="table table-striped">
                                <thead>
                                    <th>#</th>
                                    <th>Task</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(task, index) in tasks" :key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ task.body }}</td>
                                        <td>{{ task.completed == true ? 'Completed' : 'Not Completed' }}</td>
                                        <td>
                                            <button class="btn btn-success" @click="completeTask(index)" v-if="task.completed != true">
                                                <span class="lnr lnr-checkmark-circle"></span>
                                            </button>
                                            <button class="btn btn-danger" @click="deleteTask(index)">
                                                <span class="lnr lnr-trash"></span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else class="text-center mt-5">
                            Nothing to display at this time.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="add_task_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label>Task</label>
                            <input type="text" name="body" id="body" v-model="task.body" placeholder="Enter task to perform" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="createTask" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                task: {
                    body: '',
                },
                tasks: [],
                errors: []
            }
        },
        
        mounted() {
            this.fetchTasks();
        },

        methods: {
            fetchTasks() {
                axios.get('/api/tasks').then(response => {
                    this.tasks = response.data.tasks;
                    console.log(this.tasks);
                });
            },

            initAddTask() {
                $('#add_task_modal').modal('show');
            },

            createTask() {
                axios.post('/api/tasks', {
                    body: this.task.body
                }).then(response => {
                    this.reset();
                    this.tasks.push(response.data.task);
                    $('#add_task_modal').modal('hide');
                }).catch(error => {
                    if (error.response.data.errors && error.response.data.errors.body) {
                        this.errors.push(error.response.data.errors.body[0])
                    }
                });
            },

            reset() {
                this.task.body = '';
            },

            completeTask(index) {
                axios.patch(`/api/tasks/${this.tasks[index].id}/complete`).then(response => {
                    this.tasks[index].completed = true;
                }).catch(error => {
                    console.log(error);
                });
            },

            deleteTask(index) {
                axios.delete(`/api/tasks/${this.tasks[index].id}/delete`).then(response => {
                    this.tasks.splice(index, 1);
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>