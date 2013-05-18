<?php namespace NaApri\DoctrineSchemaToolL4;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use \Doctrine\ORM\Tools\Setup;

class DoctrineSchemaToolL4Manager {
	protected $entityManagers = [];
	protected $metadataConfig = null;
	
	public function __construct() {
		$directory = Config::get('doctrine-schema-tool-l4::doctrine.directory');
		if(!is_array($directory)){
			$directory = [$directory];
		}

		$dataType = strtolower(
			Config::get('doctrine-schema-tool-l4::doctrine.metatype', '')
		);
		
		switch ($dataType){
			case 'xml':
				$this->metadataConfig
					= Setup::createXMLMetadataConfiguration(
						$directory
					);
				break;
			case 'yaml':
				$this->metadataConfig
					= Setup::createYAMLMetadataConfiguration(
						$directory
					);
				break;
			case 'annotation':
			default :
				$this->metadataConfig
					= Setup::createAnnotationMetadataConfiguration(
						$directory
					);
				break;
		}
	}

	public function getEntityManager($name = null){
		$name = $name ?: DB::getDefaultConnection();
		
		if ( ! isset($this->entityManagers[$name]))
		{
			$this->entityManagers[$name] = \Doctrine\ORM\EntityManager::create(
				['pdo' => DB::connection($name)->getPDO()],
				$this->metadataConfig
			);
		}
		
		return $this->entityManagers[$name];
	}
	
	public function __call($method, $parameters)
	{
		return call_user_func_array(array($this->getEntityManager(), $method), $parameters);
	}
	
	
}

