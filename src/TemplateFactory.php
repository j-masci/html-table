<?php

namespace JMasci\HtmlTable;
use JMasci\ComponentTemplate\Template;

/**
 * Static methods that create Template instances.
 *
 * Class TemplateFactory
 * @package JMasci\HtmlTable
 */
Class TemplateFactory{

    /**
     * @return Template
     */
    public static function headless()
    {
        $template = self::default();

        // filter the args passed to the table component
        $template->get('table')->add_filter(function($table, $thead = true) {
            return [$table, false];
        });

        return $template;
    }

    /**
     * @return Template
     */
    public static function default()
    {
        $template = new Template( 'table' );

        $template->set('table', function($table, $thead = true) {
            echo '<table>';
            $thead ? $this->invoke('thead', $table) : null;
            $this->invoke('tbody', $table);
            echo '</table>';
        });

        $template->set('thead', function($table) {
            echo '<thead>';
            echo '<tr>';
            foreach ($table->cols as $col_index => $col_label) {
                $this->invoke('th', $table, $col_index);
            }
            echo '</tr>';
            echo '</thead>';
        });

        $template->set('th', function($table, $index) {
            $value = $table->cols[$index];
            $class = 'col-' . $index;
            echo '<td class="' . esc_attr($class) . '">' . htmlspecialchars($value) . '</td>';
        });

        $template->set('tbody', function($table) {
            echo '<tbody>';
            foreach ($table->rows as $row_index => $row) {
                $this->invoke('tbody_row', $table, $row_index);
            }
            echo '</tbody>';
        });

        $template->set('tbody_row', function($table, $row_index) {
            echo '<tr>';
            foreach ($table->cols as $col_index => $col_label) {
                // pass indexes only
                $this->invoke('td', $table, $row_index, $col_index);
            }
            echo '</tr>';
        });

        $template->set('td', function($table, $row_index, $col_index) {

            // $col_index is not guaranteed to bet set, unlike $row_index.
            $value = is_scalar(@$table[$row_index][$col_index]) ? @$table[$row_index][$col_index] : "";
            $class = 'col-' . $col_index;

            echo '<td class="' . htmlspecialchars($class) . '">' . htmlspecialchars($value) . '</td>';
        });

        return $template;
    }

}