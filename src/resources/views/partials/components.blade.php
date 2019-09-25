<!-- Create folder dialogbox -->   
  <div class="col-md-4">
    <div class="modal fade" id="modal-file-create" tabindex="-1" role="dialog" aria-labelledby="modal-file-create" aria-hidden="true">    
      <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content bg-gradient-default">
          <form action="{{ route(config('mikdoc.routes.prefix').'.store')}}" method="POST" id="form_new_folder">
            {{ csrf_field() }}          
          <div class="modal-header">
            <h4 class="modal-title" id="modal-title-notification"><span class="text-white"><i class="fas fa-folder-plus mr-2"></i>@lang('mikdoc::messages.popups.new_folder.title')</span></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>          
          <div class="modal-body">              
            <div class="py-3 text-center text-white">
              <p class="text-left" id="folder_messages">@lang('mikdoc::messages.popups.new_folder.messages.label')</p>
              <div class="row">                  
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="text" autofocus="autofocus" required name="name" class="form-control form-control-alternative" placeholder="@lang('mikdoc::messages.popups.new_folder.placeholder')" />
                    <input name="parent" type="hidden" value="{{$dossier->id}}">
                  </div>
                </div>
              </div>
            </div>                
          </div>            
          <div class="modal-footer">
            <button class="btn btn-icon btn-3 btn-white text-default" type="button" data-dismiss="modal">             
              <span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
              <span class="btn-inner--text">@lang('mikdoc::messages.popups.new_folder.cancel_btn.title')</span>
            </button>
            <button class="btn btn-icon btn-3 btn-success text-white" type="submit">
              <span class="btn-inner--icon"><i class="fas fa-folder-plus"></i></span>              
              <span class="btn-inner--text">@lang('mikdoc::messages.popups.new_folder.ok_btn.title')</span>
            </button> 
          </div>
          </form>            
        </div>
      </div>
    </div>
  </div> 
  <!-- File Upload dialogbox -->
  <div class="col-md-6">
    <div class="modal fade" id="modal-file-upload" tabindex="-1" role="dialog" aria-labelledby="modal-file-upload" aria-hidden="true">    
      <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content bg-gradient-default">
          <form action="{{route(config('mikdoc.routes.prefix').'.upload')}}" method="POST" id="form_upload" enctype="multipart/form-data">
            {{ csrf_field() }}          
            <div class="modal-header">
              <h4 class="modal-title" id="modal-title-notification"><i class="fas fa-file-upload mr-2"></i>@lang('mikdoc::messages.popups.upload_files.title')</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>            
            <div class="modal-body">              
              <div class="py-3 text-left">
                <p id="message">@lang('mikdoc::messages.popups.upload_files.messages.label')</p>
                <div class="progress-wrapper">
                  <div class="progress-info" hidden id="progres_info">
                    <div class="progress-label">
                      <span class="text-white">@lang('mikdoc::messages.popups.upload_files.uploaded')</span>
                    </div>
                    <div class="progress-percentage">
                      <span id="progressbarText" class="text-success">0%</span>
                    </div>
                  </div>
                  <div class="row">                  
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="file" name="file[]" id="input_file" class="form-control form-control-alternative"/>
                        <input name="parent" type="hidden" value="{{ $dossier->id }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>                
            </div>
            <div class="modal-footer">
              <button class="btn btn-icon btn-3 btn-white text-default" type="button" data-dismiss="modal">
                <span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                <span class="btn-inner--text">@lang('mikdoc::messages.popups.upload_files.cancel_btn.title')</span>
              </button>
              <button class="btn btn-icon btn-3 btn-success" type="submit">
                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>              
                <span class="btn-inner--text">@lang('mikdoc::messages.popups.upload_files.ok_btn.title')</span>
              </button>
            </div>
          </form>            
        </div>
      </div>
    </div>
  </div> 