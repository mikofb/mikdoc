<script src="{{ asset('vendor/mikdoc/vendor/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript">
    $('#details_view_content').hide();
    $(document).ready(function(){
    $('#details_view_content').hide();
    $('#input').keyup(function(){
      search($(this).val(), '#table');
      });
    function search(value, tableId){
      $(tableId+' tr').each(function(){
        var found = false;
        $(this).each(function(){
          if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >=0 ){
            found = true;
          }else{
            matches = 0;
          }
        });
        if(found){
          $(this).show();
        }
        else{
          $(this).hide();
        }
      });
    }  
  });
  // Switching between simpe and details view
  jQuery(function($){
    $('#details_view_content').hide();
    $('#simple_view_btn').click(function(){
      $('#details_view_content').hide();
      $('#simple_view_content').show();
    });
    $('#details_view_btn').click(function(){
      $('#simple_view_content').hide();
      $('#details_view_content').show();
    });
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