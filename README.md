### Usage

```php
use JMasci\HtmlTable\Table;
use JMasci\HtmlTable\TemplateFactory;

// map of column indexes to column labels. Use null to infer from first row of data.
$cols = null;

// an array of arrays, or an array of stdClass objects.
$rows = $db->query( "SELECT * FROM some_table" );

// optional table arguments.
$args = [];

// inject a pre-built rendering template or build your own template to inject.
// in many projects you'll find it useful to create your own template or extend the default one to 
// inject project-specific behaviour. 
$template = TemplateFactory::default();

// "extend" the template for this instance only, by overriding one of the components.
$template->set( 'td', function($table, $row_index, $col_index ){
    
    // raw cell value that was passed into the table object.
    $raw_value = @$table->rows[$row_index][$col_index];
    
    // table args are accessible here
    if ( @$table->args['option'] ) {
        // do something differently    
    }

    // this templates components all output their HTML. Your own template may decide to return
    // it instead.      
    ?>
    <td>...</td>
    <?php       
    
    // "$this" inside of a components callback is a Template object that the component belongs to.
    // This lets us invoke other components that live within the same template, like so:         
    $this->invoke( 'some_other_component' ); 
});

$table = new Table( $cols, $rows, $args, $template );

// html table
echo $table->render();
```