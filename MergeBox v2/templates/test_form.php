<!-- Latest Sortable -->
  <script src="http://rubaxa.github.io/Sortable/Sortable.js"></script>
  
  <button id="switcher">disable</button>
  <br/>  <br/>
  <table class="table table-hover">
  	<thead>
  		<tr>
  			<th> hi </th>
  		</tr>
  	</thead>
  	<tbody>
	  <tr id="list" class="list-group">
	    <td class="list-group-item">This is <a href="http://rubaxa.github.io/Sortable/">Sortable</a></li>
	    <td class="list-group-item">It works with Bootstrap...</li>
	    <td class="list-group-item">...out of the box.</li>
	    <td class="list-group-item">It has support for touch devices.</li>
	    <td class="list-group-item">Just drag some elements around.</li>
	  </tr>
	</tbody>
  </table>

  <script>var sortable = Sortable.create(list);

switcher.onclick = function () {
	var state = sortable.option("disabled"); // get

	sortable.option("disabled", !state); // set
  
    switcher.innerHTML = state ? 'disable' : 'enable';
};
</script>