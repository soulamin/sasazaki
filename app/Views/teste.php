<div class="container-fluid pt-4">
	<div class="row">
    	<div class="col-2">
			<!-- Note the missing multiple attribute! -->
			<select id="example-single-selected" multiple="multiple">
			    <option value="1">Option 1</option>
			    <option value="2" selected="selected">Option 2</option>
			    <!-- Option 3 will be selected in advance ... -->
			    <option value="3" selected="selected">Option 3</option>
			    <option value="4">Option 4</option>
			    <option value="5">Option 5</option>
			    <option value="6">Option 6</option>
			</select>
	  	</div>
    	<div class="col-2">
	  		<select aria-label="Ordenar" id="orderAlfa" name="orderAlfa">
	  			<option value="">Ordenar</option>
	  			<option value="az">A - Z</option>
	  			<option value="za">Z - A</option>
	  		</select>
	  	</div>
  	</div>
</div>
  		
<script type="text/javascript">	  		
	$(window).load(function(){  
	$('#example-single-selected').multiselect();
	$('#orderMaterial').multiselect();
});
</script>