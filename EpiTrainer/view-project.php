<?php
include("View/header.php");
require_once("Model/ProjectModel.php");
require_once("Model/ClassModel.php");
?>
<script type="text/javascript">
$(document).ready(function(){
        $("a").removeClass("active");
        $("#li-viewproject").addClass("active");
});
document.title = "View Project | EpiTrainer";
</script>
<h1 class="heading-top">Existing Projects</h1>
<?php
$projects = ProjectModel::getMyProjects($person['person_id']);

print   '
        <div class="content">
            <center>
            <table border="1" class="StyledForm">
                <tr>
                    <th>#</th>
                    <th>Created</th>
                    <th>Title</th>
                    <th>Details</th>
                    <th>Deadline</th>
                    <th>Edit</th>
                </tr>
        ';
                
            for($i=0; $i<count($projects); $i++){
                
                print   '
                        <tr>
                            <td>'.($i+1).'</td>
                            <td>'.$projects[$i]["created_at"].'</td>
                            <td><a href="project.php?pid='.$projects[$i]["project_id"].'">'.$projects[$i]["title"].'</a></td>
                            <td><strong>Subject: </strong>'.$projects[$i]["subject"].'<br/><br/><small><strong>Class: </strong>
                        ';
                            ClassModel::showName($projects[$i]["class_id"]);
                print   '<br/><br/><strong>Project URL: </strong><i>http://www.localhost:8888/EpiTrainer/project.php?pid='.$projects[$i]["project_id"].'</i></small></td>
                            <td>'.$projects[$i]["deadline"].'</td>
                            <td><a href="edit-project.php?pid='.$projects[$i]["project_id"].'"><image src="images/edit.png" alt="Edit" title="Edit"></a></td>
                        </tr>
                        ';
            }
            
print '
            </table>
            </center>
        </div>';


include("View/footer.php");
?>
