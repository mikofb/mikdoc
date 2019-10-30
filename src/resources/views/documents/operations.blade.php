@extends('mikdoc::layouts.master')

@section('title')
Documents
@stop

@section('page-header')
	@include('mikdoc::partials.header')
@stop

@section('page-content')
	<div class="row">
        <div class="col col-xl-8 mb-5 mb-xl-0">
          	<div class="card shadow">
            	<div class="card-header bg-transparent">
              		<h3 class="mb-0">
              			<a href="{{ route(config('mikdoc.routes.prefix').'.show', $document->parent()->slug) }}" id='back' class="btn btn-sm btn-secondary mr-2" data-toggle="tooltip" data-placement="bottom" title="Parent">
	                		<i class="ni ni-bold-left"></i>
	             		</a>
              			<span class="text-muted">
                  			<i class="fas fa-{{ $document->is_file()?'file text-blue':'folder text-yellow' }}"></i>
                		</span>
              			{{$document->name}}
          			</h3>
            	</div>
            	<div class="card-body">
              		<div class="row mb-0">
                		<div class="col-md-5"><b>@lang('mikdoc::messages.last_update')</b></div>
                		<div class="col-md-7">
                  			{{ $document->updated_at }}
                		</div>                
                		@if($document->is_file())
                		<div class="col-md-5">
                			<b>
                				@lang('mikdoc::messages.size')
                			</b>
                		</div>
                		<div class="col-md-7">
                			{{ $document->size }}
                		</div>
                		@else
                		<div class="col-md-5">
                			<b>
                				@lang('mikdoc::messages.content')
                			</b>
                		</div>
                		<div class="col-md-7">
                			{{ $document->documents->count() }} 
                			@if($document->documents->count() == 0)
							{{ trans('mikdoc::messages.element') }}
                			@else
                			{{ $document->documents->count() >1? trans('mikdoc::messages.elements'):trans('mikdoc::messages.element')  }}
                			@endif
                		</div>
                		@endif
              		</div>
              		@if(!$document->is_file())
              		<h4 class="text-muted text-uppercase  mt-5">@lang('mikdoc::messages.content')</h4>
              		<div class="card">
                		<div class="card-body">
                  			<div class="table-responsive">
                    			<table class="table align-items-center table-flush" id="documents_table">
                      				<tbody>
                        			@forelse($document->documents as $doc)
                        				<tr>
                          					<th scope="row">
                            					<div class="media align-items-center">
                              						<a href="#" class="icon icon-shape bg-secondary text-{{ $doc->is_file()?'blue':'yellow' }} rounded-circle shadow">
                                						<i class="fas fa-{{ $doc->is_file()?'file':'folder' }}"></i>
                              						</a>
                              						<div class="media-body">
                                						<span class="mb-0 text-sm">
                                  							<a href="{{ route(config('mikdoc.routes.prefix').'.show', $doc->slug) }}">
                                    							{{ $doc->name }}
                                  							</a>
                                						</span>
                              						</div>
                            					</div>
                          					</th>
                          					<td class="text-right">
					                            <a class="btn btn-sm btn-white" role="button" href="{{ route(config('mikdoc.routes.prefix').'.destroy', $doc) }}" data-method="delete" name="document_delete">
					                              	<span class="text-danger">
					                                	<i class="fas fa-trash-alt"></i>
					                              	</span>
					                            </a>
				                            	<a class="btn btn-sm btn-white" href="{{route(config('mikdoc.routes.prefix').'.operations', $doc->slug)}}" role="button">
				                              		<i class="fas fa-ellipsis-v"></i>
				                            	</a>
				                          	</td>
                        				</tr>
				                        @empty
				                        <tr>
				                          	<th scope="row">
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
				                          	</th>
				                        </tr>
                        				@endforelse                                  
                      				</tbody>
                    			</table>
                  			</div>
                		</div>
              		</div>
              		@else
              		<h4 class="text-muted text-uppercase mt-5">@lang('mikdoc::messages.file_preview')</h4>
              		<div class="row card">
                		<div class="col-lg-12 card-body">
                    		<div class="form-group text-center">
                    			<a href="{{route(config('mikdoc.routes.prefix').'.show', $document->slug)}}" target="_blank">
                      				<button type="button" class="btn btn-icon btn-3 btn-white text-default">
                        				<span class="btn-inner--icon"><i class="fas fa-eye"></i></span>           
                        				<span class="btn-inner--text">@lang('mikdoc::messages.load')</span>      
                      				</button>
                  				</a>
                    		</div>
               	 		</div>
              		</div>
              		@endif
            	</div>
          	</div>
        </div>
        <div class="col-xl-4">
          	<div class="card shadow">
            	<div class="card-header bg-transparent">
              		<div class="row align-items-center">
                		<div class="col">
                  			<h3 class="mb-0">@lang('mikdoc::messages.properties')</h3>
                		</div>
              		</div>
            	</div>
            	<div class="card-body">
            		<form action="{{ route(config('mikdoc.routes.prefix').'.update', $document)}}" method="POST">
            			{{csrf_field()}}
            			<input type='hidden' name='_method' value='PUT'>
            			<div class="pl-lg-1 pr-lg-1">
            				<div class="row">
            					<div class="col-lg-12">
            						<div class="form-group">
            							<div class="form-control-label">@lang('mikdoc::messages.name')</div>
            							<div class="input-group input-group-alternative">
			                    			<div class="input-group-prepend">
			                      				<span class="input-group-text">
			                      					<i class="fas fa-{{ $document->is_file() ? 'file':'folder' }}"></i>
			                      				</span>
			                    			</div>
			                    			<input class="form-control form-control-alternative" id="name" name="name" type="text" required value="{{ $document->name }}">
			                  			</div>
            						</div>
            					</div>
            				</div>
            				<div class="row">
            					<div class="col-lg-12">
            						<div class="form-group">
            							<label class="form-control-label" for="direction_regionale">
            								@lang('mikdoc::messages.move.label')
            							</label>
		                    			<select name="parent" class="form-control form-control-alternative" data-toggle="select" data-live-search="true">
		                      				<option>@lang('mikdoc::messages.move.message')</option>
		                      				<option value="1">@lang('mikdoc::messages.root')</option>
		                      				@foreach($dossiers as $dossier)
                                    @if($document->is_file())
                                    <option value="{{$dossier->id}}" {{$document->parent()->id == $dossier->id ? 'selected' : ''}}>
                                    {{$dossier->name}}
                                  </option>
                                    @else
                                      @if($dossier->id != $document->id && !$document->has($dossier->id))
                                  <option value="{{$dossier->id}}" {{$document->parent()->id == $dossier->id ? 'selected' : ''}}>
                                    {{$dossier->name}}
                                  </option>
                                      @endif
                                    @endif
		                      				@endforeach
		                    			</select>
            						</div>
            					</div>
            				</div>
                  			<div class="row">
                    			<div class="col-12">
                        			<div class="form-group text-right">
                        				<a href="{{ route(config('mikdoc.routes.prefix').'.destroy', $document) }}" data-method="delete" name="document_delete" class="mr-2">
                          					<button type="button" class="btn btn-icon btn-sm btn-danger text-white" data-toggle="tooltip" title="{{trans('mikdoc::messages.delete', ['type' => $document->is_file() ? trans('mikdoc::messages.type_file'):trans('mikdoc::messages.type_folder') ])}}">
                            					<span class="btn-inner--icon"><i class="fas fa-trash-alt"></i></span>
                            					<span class="btn-inner--text">@lang('mikdoc::messages.delete_btn')</span>   
                          					</button>
                      					</a>
                      					<button type="submit" class="btn btn-icon btn-sm btn-success text-white" data-toggle="tooltip" title="@lang('mikdoc::messages.saves.modifications')">
	                          				<span class="btn-inner--icon"><i class="fas fa-save"></i></span>
	                          				<span class="btn-inner--text">@lang('mikdoc::messages.save_btn')</span>      
	                        			</button>
                        			</div>                     	
                    			</div>
                  			</div>
            			</div>            		
            		</form>
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