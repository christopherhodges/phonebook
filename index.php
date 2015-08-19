<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Atlantic Media</title>
    <?php wp_head(); ?>
</head>
<body>

    <div id="app">
        <?php
            /*
            Build a small phone book web application that will allow you to create, view and delete people.
            The front-end should be a simple page with an interface to create a new person.
            The interface should have three fields - first name, last name, and phone number - plus a submit button.
            There must also be a list of people. The list should be ordered by last name in ascending order.
            The list should also contain a delete button that removes the user.
            The delete button should be on the right side of the list and the list should alternate background colors depending on odd/even.
            Javascript should handle basic form validation and all saves/deletes should be done via AJAX.
            PHP should handle retrieving all people, adding and removing people from a database.
            */
        ?>

        <div id="list">
            <?php
            $args = array(
    			'post_type'		=> 'people',
    			'post_status'	=> 'publish',
    			'order'			=> 'ASC',
    			'orderby'		=> 'title'
    		);

            $loop = new WP_Query( $args );

            if ( $loop->have_posts() ) :

                while ( $loop->have_posts() ) : $loop->the_post();

                    ?>
                    <div class="person" data-name="<?php the_title(); ?>" data-id="<?php the_id(); ?>">
                        <div class="person-inner">
                            <div class="person-toolbar">
                                <a href="#del">Delete</a>
                            </div>
                            <div class="person-data">
                                <div class="name"><?php the_title(); ?></div>
                                <div class="phone_number"><?php the_content(); ?></div>
                            </div>
                        </div>
                    </div>

                    <?php

                endwhile;

            endif;
            ?>
        </div>
        <nav id="toolbar">
            <a href="#add">Add Person</a>
        </nav>
        <div id="cover"></div>
        <div id="modal">
            <h1>Add New Contact</h1>
            <form>
                <input type="text" id="first_name" name="first_name" placeholder="First Name" />
                <input type="text" id="last_name" name="last_name" placeholder="Last Name" />
                <input type="tel" id="phone_number" name="phone_number" placeholder="(555) 555-5555" />
                <input type="submit" value="Add Person" />
                <input type="reset" value="Cancel" />
            </form>
        </div>
    </div>
    <div class="person template">
        <div class="person-inner">
            <div class="person-toolbar">
                <a href="#del">Delete</a>
            </div>
            <div class="person-data">
                <div class="name">last name, first</div>
                <div class="phone_number">phone number</div>
            </div>
        </div>
    </div>
</body>
<?php wp_footer(); ?>
</html>
