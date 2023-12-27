@if ($message = Session::get('success'))
<div 
    id="successMessage" 
    class="alert alert-success alert-block" 
    x-data="{show: true}" 
    x-init="setTimeout(() => show = false, 10000)"
    x-show="show" 
    style="text-align:center;"
>
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif
  
@if ($message = Session::get('error'))
<div 
    id="dangerMessage"
    class="alert alert-danger alert-block"
    x-data="{show: true}"
    x-show="show"
    style="text-align:center;"
>
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif
   
@if ($message = Session::get('warning'))
<div 
    id="warningMessage"
    class="alert alert-warning alert-block"
    x-data="{show: true}"
    x-show="show"
>
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif
   
@if ($message = Session::get('info'))
<div 
    id="infongMessage"
    class="alert alert-info alert-block"
    x-data="{show: true}"
    x-show="show"
>
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif
  
@if ($errors->any())
<div 
    id="dangerGenericMessage"
    class="alert alert-danger"
    x-data="{show: true}"
    x-show="show"
>
    <button type="button" class="close" data-dismiss="alert">×</button>    
    Ops! Alguma coisa deu errado. Por favor, procure o administrador do sistema.
</div>
@endif