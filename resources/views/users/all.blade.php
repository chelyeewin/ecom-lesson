@extends('layouts.app')

@section('title') Users @stop

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-3">
                @include('partials.menu')
            </div>
            <div class="col-sm-9">
                <div><i class="fas fa-users"></i> Users</div>
                <div class="dropdown-divider"></div>
                <div class="row">
                   <table class="table table-borderless table-hover ">
                       <tr class="bg-info">
                           <th>Name</th>
                           <th>Email</th>
                           <th>Role</th>
                           <th>Join Date</th>
                           <th>Actions</th>
                       </tr>
                       @foreach($users as $u)
                       <tr>
                           <td>{{$u->name}}</td>
                           <td>{{$u->email}}</td>
                           <td>
                               @if($u->hasAnyRole(['Admin','Member']))
                                   {{$u->roles()->first()->name}}
                                   @else
                                    Role not assign.
                                   @endif
                           </td>
                           <td>{{$u->created_at->diffForHumans()}}</td>
                           <td>
                               <a data-toggle="modal" data-target="#r{{$u->id}}" href="#" class="btn btn-outline-info btn-sm">
                                   <span data-toggle="tooltip" title="Assign User Role">
                                   <i class="fas fa-user-cog"></i>
                                   </span>
                               </a>
                               <!-- User role assign modal -->
                               <div id="r{{$u->id}}" class="modal fade" tabindex="-1" role="dialog">
                                   <div class="modal-dialog" role="document">
                                       <form method="post" action="{{route('assign.user.role')}}">
                                           @csrf
                                           <input type="hidden" name="user_id" value="{{$u->id}}">
                                       <div class="modal-content">
                                           <div class="modal-header">
                                               <h5 class="modal-title">Assign role for <b>"{{$u->name}}</b></h5>
                                               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                   <span aria-hidden="true">&times;</span>
                                               </button>
                                           </div>
                                           <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="role">Select Role</label>
                                                    <select name="role" id="role" class="custom-select">
                                                        @foreach($role as $r)
                                                            <option>{{$r->name}}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                           </div>
                                           <div class="modal-footer">
                                               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                               <button type="submit" class="btn btn-primary">Save changes</button>
                                           </div>
                                       </div>
                                       </form>
                                   </div>
                               </div>
                               <!--End User role assign modal -->
                               <a data-toggle="modal" data-target="#e{{$u->id}}" href="#" class="btn btn-outline-primary btn-sm">
                                    <span data-toggle="tooltip" title="Edit user info">
                                   <i class="fas fa-user-edit"></i>
                                    </span>
                               </a>
                               <!-- Modal for edit -->
                               <div id="e{{$u->id}}" class="modal fade" tabindex="-1" role="dialog">
                                   <div class="modal-dialog modal-sm" role="document">
                                       <div class="modal-content">
                                           <form method="post" action="{{route('update.user')}}">
                                               @csrf
                                               <input type="hidden" name="id" value="{{$u->id}}">
                                               <div class="modal-header">
                                                   <h5 class="modal-title">Edit User.</h5>
                                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                       <span aria-hidden="true">&times;</span>
                                                   </button>
                                               </div>
                                               <div class="modal-body">
                                                   <div class="form-group">
                                                       <label for="cat_name">User Name</label>
                                                       <input type="text" name="name" id="name" class="form-control" value="{{$u->name}}">
                                                   </div>
                                                   <div class="form-group">
                                                       <label for="cat_name">Email</label>
                                                       <input type="text" name="email" id="email" class="form-control" value="{{$u->email}}">
                                                   </div>
                                               </div>
                                               <div class="modal-footer">
                                                   <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                                   <button type="submit" class="btn btn-outline-primary">Save Change</button>
                                               </div>
                                           </form>
                                       </div>
                                   </div>
                               </div>
                               <!-- End Modal for edit -->
                               <a data-toggle="modal" data-target="#d{{$u->id}}" href="#" class="btn btn-outline-danger btn-sm">
                                    <span data-toggle="tooltip" title="Drop User info">
                                   <i class="fas fa-user-times"></i>
                                    </span>
                               </a>
                               <!-- Model for delete -->
                               <div id="d{{$u->id}}" class="modal fade" tabindex="-1" role="dialog">
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
                                               <p>Are you sure ? The user name <b>"{{$u->name}}"</b> will be deleted permanently.</p>
                                           </div>
                                           <div class="modal-footer">
                                               <a href="{{route('delete.user',['id'=>$u->id])}}" class="text-dark">Agree</a>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <!-- End Model for delete -->
                           </td>
                       </tr>
                           @endforeach
                   </table>
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
