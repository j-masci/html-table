<?php

namespace JMasci\HtmlTable;

/**
 * Filters rows/columns in preparation for rendering. You might
 * pass this class or properties of this class to a rendering
 * function elsewhere.
 *
 * Class BaseTable
 * @package JMasci\HtmlTable
 */
Trait T_Filters
{

    /**
     * @param $cols
     * @param array $rows
     * @return array
     */
    public static function filter_cols_rows( $cols, array $rows ) {
        $_rows = self::filter_rows( $rows );
        $_cols = self::filter_cols( $cols, $_rows );
        return [ $_cols, $_rows ];
    }

    /**
     * Filter/validate the rows passed into the constructor.
     *
     * Public and static because this has potential usage
     * outside of this classes constructor.
     *
     * @param array $rows
     * @return array
     */
    public static function filter_rows( array $rows )
    {
        if( !is_array( $rows ) ) {
            return [];
        }

        foreach ( $rows as $key => $value ) {
            if( is_object( $value ) ) {
                $rows[ $key ] = get_object_vars( $value );
            } else if( !is_array( $value ) ) {
                $rows[ $key ] = [];
            }
        }

        return $rows;
    }

    /**
     * Filter/validate the column headings passed into the constructor.
     *
     * Depends on the filtered and validated rows.
     *
     * @param $cols
     * @param array $rows
     * @return array
     */
    public static function filter_cols( $cols, array $rows )
    {
        if( $cols && is_array( $cols ) ) {
            // todo: possibly modify a numerically indexed array? might not be able to do so without breaking other things.
            return $cols;
        } else if( $cols === null ) {

            if( isset( $rows[0] ) && is_array( $rows[0] ) ) {

                $_cols = [];
                foreach ( $rows[0] as $key => $value ) {
                    $_cols[$key] = $key;
                }

                return $_cols;
            } else {
                return [];
            }

        } else {
            return [];
        }
    }

    /**
     * Very redundant looking function. @see Table.
     *
     * @param $args
     * @return mixed
     */
    public static function filter_args( $args ) {
        return $args;
    }
}