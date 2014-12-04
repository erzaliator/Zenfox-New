{if 'development' eq $APPLICATION_ENV}
	<div class='error'>
	  <h3>Request Parameters:</h3>
	  <pre>{isset($request)? {$request->getParams()|@var_dump}:null}
	  <pre>{isset($exception)? {$exception->getMessage()|@var_dump}:null}
	  </pre>
	
	</div>
{/if}
{$form}