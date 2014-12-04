{$changePasswordForm}
{if isset($message)}
	{$message}
	{$this->headMeta()->appendHttpEquiv('Refresh','3;URL='|cat:$link}
{/if}
