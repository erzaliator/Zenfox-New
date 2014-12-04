<?php
class Zenfox_Paginator extends Zend_Paginator implements Countable, IteratorAggregate
{
	private $_doctrineAdapter;
	private $_currentPageNo;
	public function __construct($adapter)
	{
		parent::__construct($adapter);
		$this->_doctrineAdapter = $adapter;
	}
	
	public function getItemsByPage($pageNumber)
    {
    	$itemsPerPage = parent::getItemCountPerPage();
        /*$pageNumber = $this->normalizePageNumber($pageNumber);

        if ($this->_cacheEnabled()) {
            $data = self::$_cache->load($this->_getCacheId($pageNumber));
            if ($data !== false) {
                return $data;
            }
        }
*/
        $offset = ($pageNumber - 1) * $itemsPerPage;

        $items = $this->_doctrineAdapter->getItems($offset, $itemsPerPage);
        
        if(count($items))
        {
	        $filter = parent::getFilter();
	
	        if ($filter !== null) {
	            $items = $filter->filter($items);
	        }
	
	        if (!$items instanceof Traversable) {
	            $items = new ArrayIterator($items);
	        }
        }

        /*if ($this->_cacheEnabled()) {
            self::$_cache->save($items, $this->_getCacheId($pageNumber), array($this->_getCacheInternalId()));
        }*/

        return $items;
    }
    
	public function getIterator()
    {
        return $this->getItemsByPage($this->_currentPageNo);
    }
    
    public function setCurrentPageNumber($pageNumber)
    {
    	$this->_currentPageNo = $pageNumber;
    	parent::setCurrentPageNumber($pageNumber);
    	return $this;
    }
    
    public function getCurrentItemCount()
    {
    	return count($this->getItemsByPage($this->_currentPageNo));
    }
    
}