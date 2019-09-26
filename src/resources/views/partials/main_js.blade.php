<script src="{{ asset('vendor/mikdoc/vendor/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript">
    const xhr = new XMLHttpRequest();    
    xhr.addEventListener('load', results);
    $('#input').keyup(function(){
      research($(this).val());
      });
    function research(argument) {
      if (argument != '') {
        document.getElementById('results').setAttribute('hidden','hidden')
        document.getElementById('results_display').innerHTML = ''
        xhr.open('get', '{{ route(config('mikdoc.routes.prefix').'.search') }}'+'/'+argument);
        xhr.send();
      }
    }
    function results(data) {
    //console.log(data)
      response = JSON.parse(data.currentTarget.response)
      //console.log(response)
      document.getElementById('results').removeAttribute('hidden')
      document.getElementById('results_display').innerHTML = response
    }
    //Switching between simpe and details view
    $('#simple_view_btn').click(function(){
      switch_view('simple');
    });
    $('#details_view_btn').click(function(){
      switch_view('details');
  });
    function switch_view(argument) {
      if (argument == 'simple') {
        document.getElementById('details_view_content').setAttribute('hidden', 'hidden')
        document.getElementById('simple_view_content').removeAttribute('hidden')
      }else if(argument == 'details'){
        document.getElementById('simple_view_content').setAttribute('hidden', 'hidden')
        document.getElementById('details_view_content').removeAttribute('hidden')
      }
    }
  jQuery(function($){
    $('[data-method]').append(function(){
        return "\n"+
        "<form action='"+$(this).attr('href')+"' method='POST' name='"+$(this).attr('name')+"' style='display:none'>\n"+
        "   <input type='hidden' name='_method' value='"+$(this).attr('data-method')+"'>\n"+
        "   <input type='hidden' name='_token' value='"+$('meta[name="_token"]').attr('content')+"'>\n"+
        "</form>\n"
    })
    .removeAttr('href')
    .attr('onclick','$(this).find("form").submit();');

    $('form[name='+$('[data-method]').attr('name')+']').submit(function(){
        return confirm('{{trans('mikdoc::messages.alert_destroy')}}');
    });
  })
  </script>
  {{--@include('sweetalert::alert')--}}
  <script src="{{ asset('vendor/mikdoc/js/backToTop/backToTop.js') }}"></script>
  <script src="{{ asset('vendor/mikdoc/js/backToTop/util.js') }}"></script>
  <script src="{{ asset('vendor/mikdoc/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Argon JS -->
  <script src="{{ asset('vendor/mikdoc/js/argon.js?v=1.0.0') }}"></script>