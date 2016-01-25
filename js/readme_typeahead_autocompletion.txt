



from http://www.simonbattersby.com/blog/jquery-ui-autocomplete-with-a-remote-database-and-php/



I spent some time last night struggling with jQuery UI Autocomplete. I was trying to use a remote data source, and was calling a php script to interrogate the database, no ajax. During the course of getting it to work properly, I discovered a couple of things that aren’t very clear in the documentation.

The basic javascript, lifted straight from the jQuery UI demo is:

        $("#autocomplete").autocomplete({
            source: "search.php",
            minLength: 2,       //search after two characters
            select: function(event,ui) {
                //do something
            }
        });

Fine so far. There was one major thing that fooled me. If, instead of using a php script, you use a local source, something like:

        source: [{"value":"Some Name","id":1},{"value":"Some Othername","id":2}]

then this local data is queried each time a character is entered in the required field. I assumed, therefore, 
that all I had to replicate in my search.php script, was a query to return all the values from my database. 
Wrong! I need to pass a search term to my php script in order to return only the correct subset of data. I further 
discovered that jQuery UI Autocomplete passes this data as a GET entitled ‘term’ (didn’t see this anywhere in the examples). 
So, armed with this knowledge, my php script looks like this:

        //connect to your database

        $term = trim(strip_tags($_GET['term']));             //retrieve the search term that autocomplete sends

        $qstring = "SELECT description as value,id FROM test WHERE description LIKE '%".$term."%'";
        $result = mysql_query($qstring);//query the database for entries containing the term

        while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
        {
                $row['value']=htmlentities(stripslashes($row['value']));
                $row['id']=(int)$row['id'];
                $row_set[] = $row;//build an array
        }
        echo json_encode($row_set);//format the array into json data


Hope this explanation is useful. No demo this time, because it doesn’t seem very interesting. You can have a look 
at an integration of jQuery UI Autocomplete with a vertical slider here and see a demo here.

