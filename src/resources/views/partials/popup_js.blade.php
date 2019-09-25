<script>
  const form_upload = document.getElementById('form_upload');
  const form_new_folder = document.getElementById('form_new_folder');
  const input_file = document.getElementById('input_file');
  const progressbarText = document.getElementById('progressbarText');
  const xhr_upload = new XMLHttpRequest();
  const xhr_folder = new XMLHttpRequest();              
  form_upload.addEventListener('submit', uploadFile);
  form_new_folder.addEventListener('submit', createFolder);
  xhr_upload.addEventListener('load', uploadCompleted);
  xhr_folder.addEventListener('load', folderCreated);
  function uploadFile(e)
  {
    e.preventDefault(); 
    document.getElementById('progres_info').removeAttribute('hidden');                   
    document.getElementById('message').innerHTML= '{{trans('mikdoc::messages.popups.upload_files.messages.waiting')}}';
    progressbarText.textContent = "0%";
    xhr_upload.open('post', '{{ route(config('mikdoc.routes.prefix').'.upload') }}');
    xhr_upload.upload.addEventListener('progress', e => {
      const percent = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;
      progressbarText.textContent = percent.toFixed(2)+'%';
    });
    xhr_upload.send(new FormData(form_upload));
  }
  function createFolder(e)
  {
    e.preventDefault();                    
    document.getElementById('folder_messages').innerHTML= '{{trans('mikdoc::messages.popups.new_folder.messages.waiting')}}';
    xhr_folder.open('post', '{{ route(config('mikdoc.routes.prefix').'.store') }}');
    xhr_folder.send(new FormData(form_new_folder));
  }
  function uploadCompleted(data) 
  {
    response = JSON.parse(data.currentTarget.response)
    if (response.success)
    {
      document.getElementById('message').innerHTML= '{{trans('mikdoc::messages.popups.upload_files.messages.success')}}';
      getBack();
    }
    else if(response.error)
    {
      document.getElementById('message').innerHTML= '{{trans('mikdoc::messages.popups.upload_files.messages.error')}}';
    }
    else if(response.exists)
    {
      document.getElementById('message').innerHTML= '{{trans('mikdoc::messages.popups.upload_files.messages.exists')}}';
    }
    else if(response.empty)
    {
      document.getElementById('message').innerHTML= '{{trans('mikdoc::messages.popups.upload_files.messages.empty')}}';
    }
  }
  function folderCreated(data) 
  {
    //console.log(data.currentTarget)
    response = JSON.parse(data.currentTarget.response)
    //console.log(response)
    if (response.success)
    {
      document.getElementById('folder_messages').innerHTML= '{{trans('mikdoc::messages.popups.new_folder.messages.success')}}';
      getBack();
    }
    else if(response.error)
    {
      document.getElementById('folder_messages').innerHTML= '{{trans('mikdoc::messages.popups.new_folder.messages.error')}}';
    }
  }
  function getBack() 
  {
    if (document.getElementById('back') == undefined) 
    {
      document.getElementById('root').click();
    }
    else
    {
      document.getElementById('back').click();
    }
  }
</script>