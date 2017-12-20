# Modular data services <br> for Zend Framework 2

**Work in progress...**

Provides lightweight data store.

- [API](http://webino.github.io/WebinoData/api/)

## Features

  - Configurable SQL select
  - Common search support
  - Input filtering
  - [TODO]

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

## Development

We will appreciate any contributions on development of this module.

Learn [How to develop Webino modules](https://github.com/webino/Webino/wiki/How-to-develop-Webino-module)

## Addendum

  Please, if you are interested in this Zend Framework module report any issues and don't hesitate to contribute.

[Report a bug](https://github.com/webino/WebinoData/issues) | [Fork me](https://github.com/webino/WebinoData)
