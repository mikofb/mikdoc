          <div class="row">
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">@lang('mikdoc::messages.header_total_folders_label')</h5>
                      <span class="h2 font-weight-bold mb-0">{{ \Mikdoc::countAllFolders(auth()->user()->id) }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-folder"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-nowrap">@lang('mikdoc::messages.header_total_folders'){{ \Mikdoc::countAllFolders(auth()->user()->id) > 1 ? 's' : '' }}</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">you have</h5>
                      <span class="h2 font-weight-bold mb-0">{{ \Mikdoc::countAllFiles(auth()->user()->id) }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-file"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-nowrap">@lang('mikdoc::messages.header_total_files'){{ \Mikdoc::countAllFiles(auth()->user()->id) > 1 ? 's' : ''}}</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <span class="h2 font-weight-bold mb-0">@lang('mikdoc::messages.header_folders')</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-folder-plus"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-nowrap">
                      <a href="#modal-file-create" data-toggle="modal" data-target="#modal-file-create">@lang('mikdoc::messages.new_folder')</a>
                    </span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                      <span class="h2 font-weight-bold mb-0">@lang('mikdoc::messages.header_files')</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-upload"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-nowrap" ><a href="#modal-file-upload" data-toggle="modal" data-target="#modal-file-upload">@lang('mikdoc::messages.upload_files')</a></span>
                  </p>
                </div>
              </div>
            </div>
          </div>