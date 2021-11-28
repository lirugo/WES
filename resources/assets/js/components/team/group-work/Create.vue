<template>
    <div>
        <!--Modal trigger-->
        <div class="fixed-action-btn">
            <button data-target="team-group-work-modal-create" class="btn-floating btn-large waves-effect waves-light green tooltipped modal-trigger" data-position="left" data-tooltip="Create Group Work">
                <i class="large material-icons">add</i>
            </button>
        </div>
        <!-- Modal Structure -->
        <div class="modal modal-fixed-footer" id="team-group-work-modal-create">
            <!--Upload bar-->
            <div class="progress m-t-0 red" v-if="isUploading">
                <div class="indeterminate orange"></div>
            </div>
            <div class="modal-content">
                <h4 class="center-align">Create Group Work</h4>
                <div class="row m-b-0">
                    <!--Errors-->
                    <span v-if="errors.length">
                        <b>Errors:</b>
                        <ul class="m-b-0 m-t-0">
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>
                    </span>
                    <!--Title-->
                    <div class="input-field col s12 m-b-0">
                        <input placeholder="Write title here" id="title" name="title" type="text" class="validate" v-model="groupWork.title" required>
                    </div>
                    <!--Description-->
                    <div class="input-field col s12">
                        <textarea id="description" name="description" placeholder="Write description here" v-model="groupWork.description" class="materialize-textarea" required></textarea>
                    </div>
                    <!--Max mark-->
                    <div class="input-field col s12 m-b-0">
                      <input placeholder="Set max mark here" id="max_mark" name="max_mark" type="number" class="validate" v-model="groupWork.max_mark" required>
                    </div>
                </div>
                <!--Date picker-->
                <div class="row m-b-0 valign-wrapper">
                    <datepicker
                        :date="groupWork.start_date"
                        :option="option"
                        class="m-l-10"
                        ></datepicker>
                    <datepicker
                        :date="groupWork.end_date"
                        :option="option"
                        class="m-l-10"
                        ></datepicker>
                </div>
                <!--Attaching files-->
                <div class="row">
                    <div v-for="(file, index) in groupWork.files">
                        <div class="input-field col s10 m-b-0">
                            <i class="material-icons prefix">attachment</i>
                            <input placeholder="Write name of education material" name="file" id="file" type="text"
                                   v-model="file.name" class="validate" required>
                        </div>
                        <div class="input-field col s2">
                            <a href="#" @click="deleteRow(index)"><i class="material-icons prefix center-align icon-red">delete</i></a>
                        </div>
                        <div class="col s12 file-field input-field">
                            <div class="btn indigo">
                                <span>File</span>
                                <input type="file" :id="'upload-'+index" required>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" placeholder="Upload file" @change="uploadFile(index)"
                                       type="text">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a class="modal-close waves-effect waves-green btn-flat">Close</a>
                <a class="waves-effect waves-green btn-flat" @click="save">Create</a>
                <a class="waves-effect waves-green btn-flat left" @click="addRow">Add file</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Group work | create widget mounted.')
            //Init modal create
            var elem = document.querySelector('#team-group-work-modal-create');
            this.instance = M.Modal.init(elem);
        },
        props: ['save_work'],
        data() {
            return {
                instance: null,
                errors: [],
                isUploading: false,
                groupWork: {
                    title: null,
                    description: null,
                    start_date: {
                        time: ''
                    },
                    end_date: {
                        time: ''
                    },
                    files: []
                },
                option: {
                    type: 'day',
                    week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    placeholder: 'Select date',
                    buttons: {
                        ok: 'Create',
                        cancel: 'Cancel'
                    },
                    format: 'YYYY-MM-DD'
                },
            }

        },
        methods: {
            save(){
                this.errors = [];

                if (!this.groupWork.title) {
                    this.errors.push('Title wrong or empty');
                }
                if (!this.groupWork.description) {
                    this.errors.push('Description wrong or empty');
                }
                if (!this.groupWork.start_date.time) {
                    this.errors.push('Start date wrong or empty');
                }
                if (!this.groupWork.end_date.time) {
                    this.errors.push('End date wrong or empty');
                }

                if (this.groupWork.title && this.groupWork.description && this.groupWork.start_date.time && this.groupWork.end_date.time) {
                    this.save_work(this.groupWork)
                    this.groupWork = {
                        title: null,
                        description: null,
                        start_date: {
                            time: ''
                        },
                        end_date: {
                            time: ''
                        },
                        files: []
                    }
                    // Close modal
                    this.instance.close()
                }
            },
            addRow() {
                this.groupWork.files.push({
                    name:null,
                    file:null
                })
            },
            deleteRow(index) {
                this.groupWork.files.splice(index, 1)
            },
            uploadFile(index) {
                let formData = new FormData()
                this.isUploading = true
                const parent = this;
                formData.append('file', document.getElementById('upload-' + index).files[0]);
                axios.post('/team/{!! $team->name !!}/group-work/store/file', formData,
                    ).then(function (response) {
                        parent.groupWork.files[index].file = response.data
                        parent.isUploading = false
                    })
                    .catch(function () {
                        console.log('FAILURE!!');
                    });
            }
        }
    }
</script>
