<?php
	namespace Correcaminos\ORM;
	
	use Correcaminos\ORM\MemoryManager;
		
	class Result{
					
				private $_PdoStatement  = NULL;
				private $_reset_pointer = FALSE;
				private $_className;
		        private $_primary_column;
				
		        function __construct(\PDOStatement $statement, $class_name, $main_column)
		        {
		        	
						echo '<pre>';
						  echo var_dump('variable');
						echo '</pre>';
						die();
		            $this->_PdoStatement = $statement;
					$this->_class_name = $class_name;
					$this->_primary_column = $main_column;
		        }
				
	        //more info about the fetch -> http://php.net/manual/en/pdostatement.fetch.php
	        
	        /**
			 * Returns an array with the data of the query. It can be iterated with minimum memory consumption
			 * as if it was a fetch iteration
			 */
	        function result($ctor_args = NULL)
			{
				$className = $this->_class_name;
				$fetch_style = \PDO::FETCH_ASSOC;
				$this->check_pointer();
				$this->_reset_pointer = TRUE;
				//aquí no hace falta usar un array intermedio para enviar los datos, ya que
				//solo se llamará una vez.
				$sub_return = $this->_PdoStatement->fetchAll($fetch_style);
				
				foreach($sub_return as $s)
				{
					$retorno[] = new $className($s);
				}

				return $retorno;
			}
			
			private function check_pointer()
			{
				if($this->_reset_pointer == TRUE)
				{
					$this->_PdoStatement->execute();
					$this->_reset_pointer = FALSE;
				}
			}
	}