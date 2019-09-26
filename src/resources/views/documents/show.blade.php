@extends('mikdoc::layouts.master')

@section('title')
Documents
@stop

@section('page-header')
	@include('mikdoc::partials.header')
@stop

@section('page-content')
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header bg-transparent">
              <h4 class="mb-0">
                <a href="{{ route(config('mikdoc.routes.prefix').'.index') }}" id="root" class="btn btn-sm btn-warning">@lang('mikdoc::messages.root')</a>
                @if($dossier->id != 1)
                <a href="{{ route(config('mikdoc.routes.prefix').'.show', $dossier->parent()->slug) }}" class="btn btn-sm btn-secondary mr-2" data-toggle="tooltip" data-placement="bottom" title="Parent">
                  <i class="ni ni-bold-left"></i>
                </a>
                <a href="{{route(config('mikdoc.routes.prefix').'.operations', $dossier->slug)}}" id="back" class="text-muted">{{ $dossier->name }}</a>
                @endif                
              </h4>
            </div>
            <div class="card-body">
            @if (Route::has('login'))
              @auth
              <div class="row">
                <div class="col-md-9 col-sm-12">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input class="form-control form-control-alternative" id="input" type="text" placeholder="{{trans('mikdoc::messages.research')}}">
                  </div>
                </div>
                <br>
                <div class="col-md-3 col-sm-12 mt-2 text-right">
                  <a href="#!" id="simple_view_btn" class="btn btn-sm btn-white text-info mr-4" data-toggle="tooltip" title="{{trans('mikdoc::messages.simple_view')}}"><i class="ni ni-ungroup"></i></a>
                  <a href="#!" id="details_view_btn" class="btn btn-sm btn-white text-info mr-2" data-toggle="tooltip" title="{{trans('mikdoc::messages.details_view')}}"><i class="ni ni-bullet-list-67"></i></a>
                </div>
              </div>
              <br>
              <div class="row" id="results" hidden>
                <div class="col card">
                  <div class="card-body">
                    <p class="text-right">
                      <b>
                        <a href="#!" class="btn btn-sm btn-info" data-toggle="tooltip" title="@lang('mikdoc::messages.close_result_display')" onclick="document.getElementById('results').setAttribute('hidden', 'hidden')">&times;</a>
                      </b>
                    </p>
                    <hr class="my-2">
                    <div class="table-responsive">
                      <table class="table align-items-center table-flush" id="table">
                        <tbody id="results_display">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <br>
              <div class="row icon-examples" id="simple_view_content">
                @forelse($documents as $document)              
                <div class="col-lg-3 col-md-6">
                  <a href="{{ route(config('mikdoc.routes.prefix').'.show', $document->slug) }}">
                  <button type="button" class="btn-icon-clipboard" data-clipboard-text="{{ $document->name }}" title="{{ $document->name }}">
                    <div>
                      <i class="fas fa-{{ $document->is_file()?'file':'folder' }} text-{{ $document->is_file()?'blue':'yellow' }}"></i>
                      <span>{{ $document->name }}</span>
                    </div>
                  </button>
                  </a>
                </div>
                @empty
                <div class="col-12">
                  <div class="media align-items-center">
                    <a href="#" class="icon icon-shape bg-secondary text-danger rounded-circle shadow">
                      <i class="fas fa-folder-minus"></i>
                    </a>
                    <div class="media-body">
                      <span class="mb-0 text-sm">
                        @lang('mikdoc::messages.empty_folder')
                      </span>
                    </div>
                  </div>
                </div>
                @endforelse
              </div>
              <div class="table-responsive" hidden id="details_view_content">
                @if($documents->count() > 0)
                <table class="table align-items-center table-flush" id="table">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">@lang('mikdoc::messages.name')</th>
                      <th scope="col">@lang('mikdoc::messages.size')</th>
                      <th scope="col">@lang('mikdoc::messages.last_update')</th>
                      <th scope="col" class="text-center"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($documents as $document)
                    <tr>
                      <th scope="row">
                        <div class="media align-items-center">
                          <a href="#" class="icon icon-shape bg-secondary text-{{ $document->is_file()?'blue':'yellow' }} rounded-circle shadow">
                            <i class="fas fa-{{ $document->is_file()?'file':'folder' }}"></i>
                          </a>
                          <div class="media-body">
                            <span class="mb-0 text-sm">
                              <a href="{{ route(config('mikdoc.routes.prefix').'.show', $document->slug) }}" class="font-weight-light">
                                {{ $document->name }}
                              </a>
                            </span>
                          </div>
                        </div>
                      </th>
                      <td>
                        @if($document->is_file())
                        {{ $document->size }}
                        @else
                          @if($document->documents()->count()==0)
                        @lang('mikdoc::messages.empty_folder')
                          @else
                            @if($document->documents()->count()==1)
                        {{ $document->documents()->count() }} @lang('mikdoc::messages.element')
                            @else
                        {{ $document->documents()->count() }} @lang('mikdoc::messages.elements')
                            @endif
                          @endif
                        @endif                      
                      </td>
                      <td>
                        <span class="badge badge-dot mr-4">
                          {{ $document->updated_at }}
                        </span>
                      </td>
                      <td class="text-right">
                        <a class="btn btn-sm btn-white" role="button" href="{{ route(config('mikdoc.routes.prefix').'.destroy', $document) }}" data-method="delete" name="document_delete" data-toggle="tooltip" title="{{trans('mikdoc::messages.delete', ['type' => $document->is_file() ? trans('mikdoc::messages.type_file'):trans('mikdoc::messages.type_folder') ])}}">
                          <span class="text-danger">
                            <i class="fas fa-trash-alt"></i>
                          </span>
                        </a>
                        <a class="btn btn-sm btn-white" data-toggle="tooltip" title="{{trans('mikdoc::messages.show_more')}}" href="{{route(config('mikdoc.routes.prefix').'.operations', $document->slug)}}" role="button">
                          <i class="fas fa-ellipsis-v"></i>
                        </a>
                      </td>
                    </tr>
                    @endforeach                                 
                  </tbody>
                </table>
                @else
                <div class="col-12">
                  <div class="media align-items-center">
                    <a href="#" class="icon icon-shape bg-secondary text-danger rounded-circle shadow">
                      <i class="fas fa-folder-minus"></i>
                    </a>
                    <div class="media-body">
                      <span class="mb-0 text-sm">
                        @lang('mikdoc::messages.empty_folder')
                      </span>
                    </div>
                  </div>
                </div>
                @endif
              </div>
              @else
              <div class="row icon-examples mb-2">
                <div class="col-12 text-center">@lang('mikdoc::messages.not_logged')<a href="{{ route('login') }}" class="ml-2 btn btn-sm btn-info text-default">@lang('mikdoc::messages.login_now')</a></div>
              </div>
              @endauth
            @endif
            </div>          
            <div class="card-footer py-4">
              <nav aria-label="...">
                @if ($documents->lastPage() > 1)
                <ul class="pagination justify-content-end mb-0">
                  <li class="page-item {{ ($documents->currentPage() == 1) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $documents->url(1) }}" tabindex="-1">
                      <i class="fas fa-angle-left"></i>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                  @for ($i = 1; $i <= $documents->lastPage(); $i++)
                  <li class="page-item {{ ($documents->currentPage() == $i) ? ' active' : '' }}">
                    <a class="page-link" href="{{ $documents->url($i) }}">{{ $i }}</a>
                  </li>
                  @endfor
                  <li class="page-item{{ ($documents->currentPage() == $documents->lastPage()) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $documents->url($documents->currentPage()+1) }}">
                      <i class="fas fa-angle-right"></i>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                </ul>
                @endif
              </nav>
            </div>            
          </div>
        </div>
      </div>
@stop

@section('components')
@include('mikdoc::partials.components')
@stop

@section('js')
@include('mikdoc::partials.popup_js')
@stop