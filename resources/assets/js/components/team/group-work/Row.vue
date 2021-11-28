<template>
  <div>
    <div class="col s12">
      <div class="card">
        <span data-badge-caption="" class="new badge orange left ml-0" v-if="work.max_mark  > 0">Max mark: {{ work.max_mark }}</span>

        <div class="card-panel">
          <span class="card-title">{{work.name}}</span>

          <p>{{work.description}}</p>

          <div v-for="file in work.files">
            <form :action="'/team/group-work/getFile/' + file.file" method="POST">
              <input type="hidden" name="_token" :value="csrf">
              <button class="btn btn-small waves-effect waves-light indigo m-b-5" type="submit">
                {{file.name}}
                <i class="material-icons right">file_download</i>
              </button>
            </form>
          </div>
          <small><blockquote class="m-b-0 m-t-15">Start date - {{work.start_date}}</blockquote></small>
          <small><blockquote class="m-b-0 m-t-5">End date - {{work.end_date}}</blockquote></small>
          <a :href="'/team/'+team_name+'/group-work/'+discipline_name+'/' + work.id" class="btn btn-small waves-effect right indigo">Open</a>
          <a v-if="isManager || isTeacher" :href="'/team/'+team_name+'/group-work/'+discipline_name+'/' + work.id + '/delete'" class="btn btn-small waves-effect right red m-r-10">Delete</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      isManager: window.authManager,
      isTeacher: window.authTeacher,
    }
  },
  props: ['work', 'team_name', 'discipline_name'],
}
</script>