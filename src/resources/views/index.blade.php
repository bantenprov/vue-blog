@extends('layouts.app', ['body_class' => 'articles index'])
@section('bodyClass', ' class="articles index"')

@section('content')
<div class="container">
    <div class="row" id="artikel">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">All Articles
                  {{-- <a href="{{route('blog.create')}}" class="btn btn-default btn-xs pull-right">Create</a> --}}
                </div>
                <div class="panel-body">
                  <div class="box">
                    <div class="box-header">
                    @if (Session::has('flash_message'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <ul>
                                    <li>{{ Session::get('flash_message') }}</li>
                            </ul>
                        </div>
                    @endif
                      <button class="btn btn-primary" @click.prevent="create">Create</button>
                      <div class="box-tools pull-right">
                        <div class="input-group input-group-sm" style="width: 350px;">
                          <input type="text" v-model="cari" name="table_search" class="form-control pull-right" placeholder="Search">

                          <div class="input-group-btn">
                            <button type="submit" class="btn btn-default" @click.prevent="caridata"><i class="fa fa-search"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                      <table class="table table-hover">
                        <tr>
                          <th style="white-space: nowrap;">Title</th>
                          <th>Excerpt</th>
                          <th>Owner</th>
                          <th>Aksi</th>
                        </tr>
                        <tr v-for="result in article.data">
                          <td>@{{result.title}}</td>
                          <td>@{{result.excerpt}}</td>
                          <td>@{{result.user.name}}</td>
                          <td style="white-space: nowrap;">
                          	<button class="btn btn-info btn-xs" @click.prevent="view(result.id)">View</button>
                            <span v-if="curent.id === result.user.id">
                            	<button class="btn btn-warning btn-xs" @click.prevent="edit(result.id)">Edit</button>
          						        <button class="btn btn-danger btn-xs" @click.prevent="hapus(result.id)">Delete</button>
                            </span>
                          </td>
                        </tr>
                      </table>

                      <vue-pagination  v-bind:pagination="pagination"
                           v-on:click.native="getdata(pagination.current_page)"
                           :offset="4">
                      </vue-pagination>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                {{-- @foreach($articles as $article)
                    <div class="row article">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-8">
                            <h2>{{$article->title}}</h2>
                            <article>
                                {{ $article->excerpt }}<br>
                                <p>
                                    <a href="{!! route('blog.show', $article->id) !!}" class="">More &raquo;</a>
                                </p>
                            </article>
                            <h5>Owner: {{ $article->user->name }}</h5>
                            <p>
                                <a href="{!! route('blog.show', $article->id) !!}" class="btn btn-default btn-sm">More &raquo;</a>
                                @if( $current_user->id === $article->user->id )
                                    <a href="{!! route('blog.edit', $article->id) !!}" class="btn btn-default btn-sm">Edit &raquo;</a>

                                    <form method="POST" action="{{ route('blog.destroy', [$article->id]) }}">
                                      {{ csrf_field() }}
                                      {{ method_field('DELETE') }}
                                      <button type="submit" class="btn btn-sm btn-warning">Delete</button>
                                    </form>
                                  @endif
                                </p>
                            </div>
                            <hr>
                        </div>
                    @endforeach --}}
                    <div class="modal fade" id="hapus-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-name" id="myModalLabel">Hapus Data</h4>
                          </div>
                          <div class="modal-body">
                            Yakin ingin menghapus data ?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">N O</button>
                            <button type="submit" class="btn btn-primary" @click.prevent="hapuskonfirm(hapus_id)">O K</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="modal fade" id="notif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-name" id="myModalLabel">Notification</h4>
                          </div>
                          <div class="modal-body">@{{notification}}</div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">O K</button>
                          </div>
                        </div>
                      </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
var artikel = new Vue({
el: '#artikel',
data: {
article: '',
curent: '',
errorForm:{},
cari: '',
counter: 0,
pagination: {
  total: 0,
  per_page: 2,
  from: 1,
  to: 0,
  current_page: 1
},
offset: 4,
hapus_id:'',
notification:'',
},
methods: {


getdata:function(page){
  var url = "{{route('api.blog')}}";
  var cari = this.cari ? this.cari : '';
  this.errorForm = {};
  axios.get(url+'?cari='+cari+'&page='+page).then(response => {
      this.article = response.data.articles;
      this.curent = response.data.current_user;
      this.pagination = response.data.articles;
  }).catch(errors => {
      console.error(errors);
  });
},

create:function(){
  window.location = "{{route('blog.create')}}";
},

view:function(id){
  window.location = base_url+'/blog/'+id;
},

edit:function(id){
  window.location = base_url+'/blog/'+id+'/edit';
},

hapus:function(id){
this.hapus_id = id;
$('#hapus-data').modal('show');
},

hapuskonfirm:function(id){
axios.delete(base_url+'/blog/'+id).then(response => {
  this.getdata(this.article.current_page);
  $('#hapus-data').modal('hide');
  this.notification = 'Data has been deleted.'
  $('#notif').modal('show');
}).catch(errors=>{
  console.error(errors);
});
},

caridata:function(){
  var url = "{{route('api.blog')}}";
axios.get(url+'?cari='+this.cari).then(response => {
  this.article = response.data.articles;
  this.curent = response.data.current_user;
  this.pagination = response.data.articles;
  console.log(this.pagination);
}).catch(errors=>{
  console.error(errors);
});
}

},
created(){
this.getdata(this.pagination.current_page);
}
});

</script>
@endpush
@endsection
