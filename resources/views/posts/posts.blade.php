@extends('layouts.app')

@section('title') Posts @stop

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-3">
                @include('partials.menu')
            </div>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-3">
                        <div><i class="fas fa-tags"></i> Posts</div>
                    </div>
                    <div class="col-sm-3 offset-sm-6">
                        <form method="get" action="{{route('search.post')}}">
                            <div class="form-group">
                                <input type="search" name="q" placeholder="Search post" required class="form-control-plaintext">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="row table-responsive">
                    <table class="table table-hover table-borderless">
                        <tr class="bg-secondary text-white">
                            <th>ID</th>
                            <th>Image</th>
                            <th>Item Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Post By</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        @foreach($posts as $p)
                            <tr class="small">
                                <td>{{$p->id}}</td>
                                <td class="col-2">
                                    <img class="img-thumbnail" src="{{route('posts.image',['file_name'=>$p->image])}}">
                                </td>
                                <td>{{$p->item_name}}</td>
                                <td>{{$p->price}} MMK</td>
                                <td>{{Str::limit($p->description,50)}}</td>
                                <td>{{$p->category->cat_name}}</td>
                                <td>{{$p->user->name}}</td>
                                <td>{{$p->created_at->diffForHumans()}}</td>
                                <td>
                                    <!-- Example split danger button -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-link dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item text-secondary" href="#"><i class="fas fa-eye"></i> View Post</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-primary" href="{{route('edit.post',['id'=>$p->id])}}"><i class="fas fa-edit"></i> Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a data-toggle="modal" data-target="#d{{$p->id}}" class="dropdown-item text-danger" href="#"><i class="fas fa-times-circle"></i> Drop</a>
                                        </div>
                                    </div>

                                    <!-- Model for delete -->
                                    <div id="d{{$p->id}}" class="modal fade" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confrim.</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center text-info">
                                                    <i class="fas fa-exclamation-triangle fa-3x"></i>
                                                    <p>Are you sure ? The category name <b>"{{$p->item_name}}"</b> will be deleted permanently.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{route('post.drop',['id'=>$p->id])}}" class="text-dark">Agree</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @endforeach
                    </table>
                    {{$posts->links()}}
                </div>
            </div>
        </div>

    </div>

    @if(Session('info'))
        <div class="alert alert-success myAlert">
            {{session('info')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@stop
