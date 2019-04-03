@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if (auth()->user()->is_admin)
                @if ($applications->count())
                    @foreach($applications as $application)
                        <div class="card">
                            <h5 class="card-header">用 户 名：{{ $application->user->name }} (可添加应用：{{ $application->user->app_num }})</h5>
                            <h5 class="card-header">应用名称：{{ $application->title }}</h5>
                            <div class="card-body">
                                <h5 class="card-title">app_id：{{  $application->app_id }}</h5>

                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <button type="button" class="btn btn-secondary">可添加域名：{{ $application->user->domain_num }}</button>
                                    </div>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <button type="button" class="btn btn-secondary">域名个数：{{  $application->domain_num }}</button>
                                    </div>
                                    <div class="btn-group mr-2" role="group" aria-label="Second group">
                                        <button type="button" class="btn btn-secondary">无效域名：{{  $application->valid_num }}</button>

                                    </div>
                                </div>
                                <br>
                                <table class="table table-dark">
                                    <thead>
                                    <tr>
                                        <th scope="col">域名</th>
                                        <th scope="col">状态</th>
                                        <th scope="col">创建时间</th>
                                        <th scope="col">失效时间</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if ($application->domains->count())
                                        @foreach($application->domains as $domain)
                                            <tr>
                                                <th scope="row">{{ $domain->title }}</th>
                                                <td>{{ $domain->status ? ($domain->status == 1 ? '正常': '失效') : '未检测' }}</td>
                                                <td>{{ $domain->created_at }}</td>
                                                <td>{{ $domain->valid_at }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    @endforeach

                    {{ $applications->links() }}
                @else
                    还没有应用....
                @endif

            @else

                <div class="card">
                    <div class="card-header">
                        我的应用 (可添加应用：{{ auth()->user()->app_num }})
                        @if ($applications->count() < auth()->user()->app_num)
                            <button type="button" class="btn btn-secondary"
                                    data-toggle="modal" data-target="#exampleModal"
                                    style="float:right">添加应用</button>
                        @endif
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($applications->count())
                            @foreach($applications as $application)
                                <div class="card">
                                    <h5 class="card-header">{{ $application->title }}</h5>
                                    <div class="card-body">
                                        <h5 class="card-title">app_id：{{  $application->app_id }}</h5>

                                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                                <button type="button" class="btn btn-secondary">可添加域名：{{ auth()->user()->domain_num }}</button>
                                            </div>
                                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                                <button type="button" class="btn btn-secondary">域名个数：{{  $application->domain_num }}</button>
                                            </div>
                                            <div class="btn-group mr-2" role="group" aria-label="Second group">
                                                <button type="button" class="btn btn-secondary">无效域名：{{  $application->valid_num }}</button>

                                            </div>
                                            @if ($application->domains->count() < auth()->user()->domain_num)
                                                <div class="btn-group" role="group" aria-label="Third group">
                                                    <button type="button" data-toggle="modal" data-target=".domainModal"
                                                            class="btn btn-secondary">添加域名</button>
                                                </div>
                                            @endif
                                        </div>
                                        <br>
                                        <table class="table table-dark">
                                            <thead>
                                            <tr>
                                                <th scope="col">域名</th>
                                                <th scope="col">状态</th>
                                                <th scope="col">创建时间</th>
                                                <th scope="col">失效时间</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if ($application->domains->count())
                                                @foreach($application->domains as $domain)
                                                    <tr>
                                                        <th scope="row">{{ $domain->title }}</th>
                                                        <td>{{ $domain->status ? ($domain->status == 1 ? '正常': '失效') : '未检测' }}</td>
                                                        <td>{{ $domain->created_at }}</td>
                                                        <td>{{ $domain->valid_at }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                    {{--添加域名--}}
                                    <div class="modal fade bd-example-modal-lg domainModal"
                                         tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">添加域名</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="POST" action="{{ route('application.domain.store', $application) }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="title">域名名称</label>
                                                            <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                                   name="title" value="{{ old('title') }}"
                                                                   id="title" placeholder="" required>
                                                            @if ($errors->has('title'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('title') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">添加</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                            @endforeach

                            {{ $applications->links() }}
                        @else
                        还没有添加应用....
                        @endif


                    </div>
                </div>

            @endif
            {{--添加应用--}}
            <div class="modal fade bd-example-modal-lg" id="exampleModal"
                 tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">添加应用</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('application.store') }}" id="addForm">
                            @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">应用名称</label>
                                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                       name="title" value="{{ old('title') }}"
                                       id="title" placeholder="" required>
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">添加</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

