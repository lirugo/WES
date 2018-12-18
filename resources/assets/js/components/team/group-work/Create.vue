<template>
    <div>
        <!--Modal trigger-->
        <div class="fixed-action-btn">
            <button data-target="team-group-work-modal-create" class="btn-floating btn-large waves-effect waves-light green tooltipped modal-trigger" data-position="left" data-tooltip="Create Group Work">
                <i class="large material-icons">add</i>
            </button>
        </div>
        <!-- Modal Structure -->
        <div class="modal" id="team-group-work-modal-create">
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
                    <div class="input-field col s12 m-b-0">
                        <textarea id="description" name="description" placeholder="Write description here" v-model="groupWork.description" class="materialize-textarea" required></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="modal-close waves-effect waves-green btn-flat">Close</a>
                <a class="waves-effect waves-green btn-flat" @click="save">Create</a>
            </div>
        </div>
    </div>
</template>

<script>


    import axios from 'axios'
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
                groupWork: {
                    title: null,
                    description: null,
                    start_date: null,
                    end_date: null,
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

                if (this.groupWork.title && this.groupWork.description) {
                    this.save_work(this.groupWork)
                    this.groupWork = {
                        title: null,
                            description: null,
                            start_date: null,
                            end_date: null,
                    }
                    // Close modal
                    this.instance.close()
                }
            }
        }
    }
</script>
