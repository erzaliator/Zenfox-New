<?php
session_start();
		error_log($_POST['email']);
		$Amount=$_POST['amount'];
		$OrderId=$_POST['orderid'];
		$_SESSION['Amount']=$Amount;
		$_SESSION['OrderId']=$OrderId;
		if(isset($_POST['live']))
		{
			$_SESSION['url']="https://www.mobikwik.com/wallet.do";
			$actionUrl="https://www.mobikwik.com/views/proceedtowalletpayment.jsp";
		}
		else
		{
			$_SESSION['url'] = "https://test.mobikwik.com/mobikwik/wallet.do"; 
			$actionUrl="https://test.mobikwik.com/mobikwik/views/proceedtowalletpayment.jsp";
		}
		error_log("URL is: {$_SESSION['url']}, actionUrl is: {$actionUrl}");
?>	
<html>
<body>	
	<form name="myform" id="demo_form" action=<?php echo $actionUrl;?> method="POST">
			<input class="required email" size="50" name="email" type="hidden" value=<?php echo $_POST['email'];?>>
			<input class="required number" size="50" name="amount" type="hidden" value=<?php echo $_POST['amount'];?>>
			<input class="required number" size="50" maxlength="10" minlength="10" name="cell" type="hidden" value=<?php echo $_POST['cell'];?>>
			<input size="30" name="orderid" type="hidden" value=<?php echo $_POST['orderid'];?>>
			<input size="30" name="merchantname" type="hidden"  value=<?php echo $_POST['merchantname'];?>>
			<input size="30" name="mid" type="hidden" id="mid" value=<?php echo $_POST['mid'];?>>
			
			<input	type="hidden" name="redirecturl" value="<?php echo $_POST['redirecturl'];?>">
			
	</form>
	</body>
	</html>
<script>
document.myform.submit();
</script>
