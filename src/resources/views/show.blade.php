@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row" id="artikel">
      <div class="col-lg-12">
          <div class="panel panel-default">
              <div class="panel-heading">Article
                <button class="btn btn-default btn-xs pull-right" @click.prevent="back">Back</button>
                {{-- <a href="{{route('blog.index')}}" class="btn btn-default btn-xs pull-right">Back</a> --}}
              </div>
              <div class="panel-body">
                <div class="box" v-for="result in article.data">
                  <!-- /.box-header -->
                  <div class="box-body table-responsive no-padding">
                    <h4>@{{result.title}}</h4>
                    <h5>By: @{{result.user.name}}</h5>
                    <p>@{{result.content}}</p>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->

                {{-- <h3>{{ $article->title }}</h3>
                <h4>By: {{ $article->user->name }}</h4>
                {!! $article->content !!}
                <hr> --}}
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
id: '',
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
  var id = "{{$id_blog}}";
  var cari = this.cari ? this.cari : '';
  this.errorForm = {};
  axios.get(url+'?cari='+cari+'&page='+page+'&id='+id).then(response => {
      this.article = response.data.articles;
      this.curent = response.data.current_user;
      this.pagination = response.data.articles;
  }).catch(errors => {
      console.error(errors);
  });
},

back:function(){
  window.location = "{{route('blog.index')}}";
}
},
created(){
this.getdata(this.pagination.current_page);
}
});

</script>
@endpush
@endsection
