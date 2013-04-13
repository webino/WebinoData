# Webino modular Data service over Zend Db

**Very early alpha version**

Provides lightweight data service.

## Features

  - Configurable sql select
  - Advanced search
  - Input filter
  - Bind to form [NEED REFACTOR]
  - Auto column:
    - `datetime_add` [INCOMPLETE]
    - `datetime_update`

## Setup

Following steps are necessary to get this module working, considering a zf2-skeleton or very similar application:

  1. Run `php composer.phar require webino/webino-data:dev-develop`
  2. Add `WebinoData` to the enabled modules list

## QuickStart

  **Better to check following**

    `config/webinodataexample.local.php.dist`

    `test/resources/IndexController.php`

  **It needs update**

  - Configure the data service:

        'di' => array(
            'instance' => array(
                'exampleTable' => array(
                    'parameters' => array(
                        'table'   => 'example',
                        'adapter' => 'defaultDb',
                    ),
                ),
                'exampleDataService' => array(
                    'parameters' => array(
                        'tableGateway' => 'exampleTable',
                        'config' => array(
                            'searchIn' => array(           // search only defined columns
                                'title',
                            ),
                            'select' => array(             // list of available selects
                                'all' => array(
                                ),
                                'example' => array(
                                    'columns' => array(
                                        array(
                                            '*',
                                            new \Zend\Db\Sql\Expression('(column/10) as rating'),
                                        ),
                                    ),
                                    'where' => array(
                                        array('column!=:param')
                                    ),
                                    'limit' => 100,
                                    'order' => array(
                                        new \Zend\Db\Sql\Expression('RAND()'),
                                    ),
                                ),
                            ),
                            'input_filter' => array(
                                'column' => array(
                                    'name'       => 'column',
                                    'required'   => false,
                                    'validators' => array(
                                        array(
                                            'name' => 'digits',
                                            'options' => array(
                                            ),
                                        ),
                                    ),
                                    'filters' => array(
                                        array(
                                            'name' => 'int',
                                            'name' => 'Example\Filter',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),

  - Select array of rows:

        // Optional parameters
        $parameters = array(':param' => 'value');

        $exampleDataService->select('all');

  - Search:

        // Optional parameters
        $parameters = array(':param' => 'value');

        // Return just like term, but ignore inferior chars
        $exampleDataService->selectJust('search', $term, $parameters);

        // Return at least something like term
        $exampleDataService->selectLike('search', $term, $parameters);

  - Bind form:

        $exampleDataService->bind($form);

        $form->setData($data);
        if ($this->form->isValid()) {
            // valid data were stored
        }

  - Manual save:

        $exampleDataService->exchangeArray($row); // update if $row['id'] is not empty

  - Validate data array: *throws exception on invalid*

        $exampleDataService->validate($data);

  - Increment column in one query:

        $where = array('id' => $id);

        $exampleDataService->increment('count', $where);

  - Delete:

        $where = array('column=?' => 'value');

        $exampleDataService->delete($where);

  - Return related data rows:

        $relatedDataService->owned($exampleDataService, $id);

  - Set owner id to the related row:

        $exampleDataService->own($relatedRow, $id);

## Develop

**Requirements**

  - Linux (recommended)
  - NetBeans (optional)
  - Phing
  - PHPUnit
  - Selenium
  - Web browser

**Setup**

  1. Be sure you have configured `~/.my.cnf` for the `mysqladmin` command

  2. Clone this repository

  3. Configure the db in the `config.local.php.dist` and delete the `.dist` extension.

  4. Run `phing update`

     Now your development environment is set.

  5. Open project in (NetBeans) IDE

  6. To check module integration with the skeleton application open following directory via web browser:

  `._test/ZendSkeletonApplication/public/`

     e.g. [http://localhost/WebinoData/._test/ZendSkeletonApplication/public/](http://localhost/WebinoData/._test/ZendSkeletonApplication/public/)

  7. Integration test resources are in directory: `test/resources`

     *NOTE: Module example config is also used for integration testing.*

**Testing**

  - Run `phpunit` in the test directory
  - Run `phing test` in the module directory to run the tests and code insights

    *NOTE: To run the code insights there are some tool requirements.*

## Todo

  - Shared relations.
  - Manual insert/update.
  - Relation handle id array *(return related rows for multiple ids)*.

## Addendum

Please, if you are interested in this Zend Framework module report any issues and don't hesitate to contribute.
