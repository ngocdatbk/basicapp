<?php

namespace app\commands;

use Yii;
use yii\db\Connection;
use yii\db\Query;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\console\controllers\BaseMigrateController;

/**
 * Description of MigrateController
 *
 * @author Lamnx <nguyenxuanlam1987@gmail.com>
 */
class AppMigrateController extends BaseMigrateController
{

    public $moduleName = '';

    /**
     * @var string the name of the table for keeping applied migration information.
     */
    public $migrationTable = '{{%migration_module}}';

    /**
     * @inheritdoc
     */
    public $templateFile = '@yii/views/migration.php';

    /**
     * @inheritdoc
     * @since 2.0.7
     */
    public $generatorTemplateFiles = [
        'create_table' => '@yii/views/createTableMigration.php',
        'drop_table' => '@yii/views/dropTableMigration.php',
        'add_column' => '@yii/views/addColumnMigration.php',
        'drop_column' => '@yii/views/dropColumnMigration.php',
        'create_junction' => '@yii/views/createJunctionMigration.php'
    ];

    /**
     * @var Connection|array|string the DB connection object or the application component ID of the DB connection to use
     * when applying migrations. Starting from version 2.0.3, this can also be a configuration array
     * for creating the object.
     */
    public $db = 'db';

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return array_merge(
        parent::options($actionID), ['migrationTable', 'moduleName', 'db'] // global for all actions
        );
    }
    
    /**
     * This method is invoked right before an action is to be executed (after all possible filters.)
     * It checks the existence of the [[migrationPath]].
     * @param \yii\base\Action $action the action to be executed.
     * @return boolean whether the action should continue to be executed.
     */
    public function beforeAction($action)
    {
        if($this->moduleName) {
            $this->migrationPath = '@app/modules/' . $this->moduleName . '/migrations';
        }

        if (parent::beforeAction($action)) {
            if ($action->id !== 'create') {
                $this->db = Instance::ensure($this->db, Connection::className());
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Creates a new migration instance.
     * @param string $class the migration class name
     * @return \yii\db\Migration the migration instance
     */
    protected function createMigration($class)
    {
        
        $file = $this->migrationPath . DIRECTORY_SEPARATOR . $class . '.php';
        require_once($file);

        return new $class(['db' => $this->db]);
    }

    /**
     * @inheritdoc
     */
    protected function getMigrationHistory($limit)
    {
        if ($this->db->schema->getTableSchema($this->migrationTable, true) === null) {
            $this->createMigrationHistoryTable();
        }
        $query = new Query;
        $rows = $query->select(['version', 'apply_time'])
        ->from($this->migrationTable)
        ->andFilterWhere(['module' => $this->moduleName])
        ->orderBy('apply_time DESC, version DESC')
        ->limit(null)
        ->createCommand($this->db)
        ->queryAll();
        $history = ArrayHelper::map($rows, 'version', 'apply_time');
        unset($history[self::BASE_MIGRATION]);

        return $history;
    }

    /**
     * Creates the migration history table.
     */
    protected function createMigrationHistoryTable()
    {
        $tableName = $this->db->schema->getRawTableName($this->migrationTable);
        $this->stdout("Creating migration history table \"$tableName\"...", Console::FG_YELLOW);
        $this->db->createCommand()->createTable($this->migrationTable, [
            'version' => 'varchar(180) NOT NULL PRIMARY KEY',
            'apply_time' => 'integer',
            'module' => 'varbinary(25)',
        ])->execute();
        $this->db->createCommand()->insert($this->migrationTable, [
            'version' => self::BASE_MIGRATION,
            'apply_time' => time(),
            'module' => $this->moduleName,
        ])->execute();
        $this->stdout("Done.\n", Console::FG_GREEN);
    }

    /**
     * @inheritdoc
     */
    protected function addMigrationHistory($version)
    {
        $command = $this->db->createCommand();
        $command->insert($this->migrationTable, [
            'version' => $version,
            'apply_time' => time(),
            'module' => $this->moduleName,
        ])->execute();
    }

    /**
     * @inheritdoc
     */
    protected function removeMigrationHistory($version)
    {
        $command = $this->db->createCommand();
        $command->delete($this->migrationTable, [
            'version' => $version,
            'module' => $this->moduleName,
        ])->execute();
    }

}
