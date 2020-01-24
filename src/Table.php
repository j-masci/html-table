<?php

namespace JMasci\HtmlTable;
use JMasci\ComponentTemplate\Template;

/**
 * Stores (filtered) table data and a table rendering template in one object.
 *
 * Render is its own method so that $this can be modified (especially
 * $this->template), before calling $this->render().
 *
 * Class Table
 * @package JMasci\HtmlTable
 */
Class Table{

    /**
     * Filter cols, rows, arguments that are passed
     * to the constructor.
     */
    use T_Filters;

    /**
     * Maps indexes to labels, @see Filters
     *
     * @var
     */
    public $cols;

    /**
     * Array of arrays, @see Filters
     *
     * @var
     */
    public $rows;

    /**
     * @var mixed
     */
    public $args;

    /**
     * @var Template
     */
    public $template;

    /**
     * Table constructor.
     * @param $cols
     * @param $rows
     * @param $args
     * @param $template
     */
    public function __construct( $cols, $rows, $args = [], $template = null ){

        list( $this->cols, $this->rows ) = self::filter_cols_rows( $cols, $rows );

        $this->args = self::filter_args( $args );

        if ( $template === null ) {
            $this->template = TemplateFactory::default();
        } else {
            $this->template = $template;
        }
    }

    /**
     * Render the template, passing $this to it. This assumes
     * that the top level template component accepts $this
     * as the first parameter.
     *
     * @return mixed
     */
    public function render(){
        // invokes the 'table' component, passing in $this
        return $this->template->render( $this );
    }
}
