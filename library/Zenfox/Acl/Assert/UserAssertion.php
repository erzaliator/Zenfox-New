<?php
class Zenfox_Acl_Assert_UserAssertion implements Zend_Acl_Assert_Interface
{
	public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $user = null, Zend_Acl_Resource_Interface $blogPost = null, $privilege = null)
	{
//		print("in assertion");
//		echo '<br>';
		if(!$user instanceof Zenfox_Acl_Role_User)
		{
			print('User is not instance of Role');
			exit();
		}
		if(!$blogPost instanceof Zenfox_Acl_Resource_BlogPost)
		{
			print('Blog Post is not an instance of Resource');
			exit();
		}
		/*if($user->getRoleId() == 'publisher')
		{
			return true;
		}
		if($user->id != NULL && $blogPost->ownerUserId == $user->id)
		{
			return true;
		}
		else
		{
			return false;
		}*/
		//echo "here"; exit();
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		$roleName = $store['roleName'];
		$csrId = $store['id'];
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		$csrGroups = Doctrine::getTable('CsrGmsGroup')->findByCsrId($csrId);
		$temp = true;
		foreach($csrGroups as $group)
		{
			$dataMaskGmsGr = Doctrine::getTable('DataMaskGmsGroup')->findByGmsGroupId($group['gms_group_id']);
			foreach($dataMaskGmsGr as $dataMaskGr)
			{
				$dataMask = Doctrine::getTable('DataMask')->findOneById($dataMaskGr['data_mask_id']);
				$maskField = explode('.', $dataMask['mask_field']);
				$field = $maskField[1];
				if($privilege == $field)
				{
					return false;
				}
			}
		}
		return true;
	}
}