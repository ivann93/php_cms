<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>


<style>
    #THstatus {
        cursor: pointer;
    }
</style>


<table class="table table-bordered table-hover" id="myTable">
                          <thead>
                              <tr>
                                  <th onclick="sortTable(1)">Id</th>
                                  <th>Author</th>
                                  <th>Comment</th>
                                  <th>Email</th>
                                  <th id="THstatus" onclick="sortTable(0)">Status</th>
                                  <th>In Response to</th>
                                  <th>Date</th>
                                  <th>Approve</th>
                                  <th>Unapprove</th>
                                  <th>Delete</th>
                              </tr>
                          </thead>
                          
                           <tbody>
                             
                             <?php
                               
                                $query = "SELECT * FROM comments ORDER BY comment_status ASC";
                                $select_comments = mysqli_query($connection, $query);


                                while($row = mysqli_fetch_assoc($select_comments)){

                                $comment_id = $row['comment_id'];
                                $comment_post_id = $row['comment_post_id'];
                                $comment_author = $row['comment_author'];
                                $comment_content = $row['comment_content'];
                                $comment_email = $row['comment_email'];
                                $comment_status = $row['comment_status'];
                                $comment_date = $row['comment_date'];
                              
                                    
                                echo "<tr>";
                                echo "<td>$comment_id</td>";
                                echo "<td>$comment_author</td>";
                                echo "<td>$comment_content</td>";
                                    
//                                    $query = "SELECT * FROM cms_table WHERE cat_id = $post_category_id ";
//                                    $select_categories_id = mysqli_query($connection, $query);
//                                
//                                    while($row = mysqli_fetch_assoc($select_categories_id)){
//                                    $cat_id = $row['cat_id'];
//                                    $cat_title = $row['cat_title'];
//                                    
//                                echo "<td>{$cat_title}</td>";
//                                }
                                    
                                echo "<td>$comment_email</td>";
                                echo "<td>$comment_status</td>";
                                    
                                $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
                                $select_post_id_query = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_assoc($select_post_id_query)){
                                $post_id = $row['post_id'];
                                $post_title = $row['post_title'];
                                
                                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                                    
                                }
                                    
                                echo "<td>$comment_date</td>";
                                echo "<td><a href='comments.php?approve=$comment_id''>Approve</a></td>";
                                echo "<td><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";    
                             
                                echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete'); \" href='comments.php?delete=$comment_id'>Delete</a></td>";
                                echo "</tr>";
                                    
                                }
                               ?>
                             
                            
                          </tbody>
</table>
                      
                     <?php
                    
                        if(isset($_GET['approve'])){
                            $the_comment_id = $_GET['approve'];
                            $query = "UPDATE comments SET comment_status = 'approve' WHERE comment_id = $the_comment_id";
                            $approved_comment_query = mysqli_query($connection, $query);
                            header("Location: comments.php");
                        }

                        
                        if(isset($_GET['unapprove'])){
                            $the_comment_id = $_GET['unapprove'];
                            $query = "UPDATE comments SET comment_status = 'unapprove' WHERE comment_id = $the_comment_id";
                            $unapproved_comment_query = mysqli_query($connection, $query);
                            header("Location: comments.php");
                        }

                        if(isset($_GET['delete'])){
                            $the_comment_id = $_GET['delete'];
                            $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
                            $delete_query = mysqli_query($connection, $query);
                            header("Location: comments.php");
                        }

                    ?>
                    
                   