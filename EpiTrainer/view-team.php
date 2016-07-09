<?php
include("View/header.php");
require_once("Model/ProjectModel.php");
?>

<script type="text/javascript">
$(document).ready(function(){
        $("a").removeClass("active");
        $("#li-viewteam").addClass("active");
});
document.title = "View Team | EpiTrainer";
</script>
<h1 class="heading-top">Existing Teams</h1>

<?php
$teams = ProjectModel::getMyTeams($person['person_id']);

print   '
        <div class="content">
            <center>
            <table border="1" class="StyledForm">
                <tr>
                    <th>#</th>
                    <th>Team</th>
                    <th>Details</th>
                    <th>Members</th>
                    <th style="min-width:60px;">Edit</th>
                </tr>
        ';
                
            for($i=0; $i<count($teams); $i++){
                
                $project = ProjectModel::get($teams[$i]['project_id']);
                $members = json_decode(ProjectModel::getTeam($teams[$i]['team_id']), true);
                
                print   '
                        <tr>
                            <td>'.($i+1).'</td>
                            <td><strong><a href="team.php?tid='.$teams[$i]["team_id"].'">Team # '.$teams[$i]["team_id"].' </a></strong><br/><br/><small><i>(Created: '.$teams[$i]["created_at"].')</i></small></td>
                            <td>
                                <strong>Project: </strong><a href="project.php?pid='.$teams[$i]['project_id'].'">'.$project["title"].'</a>
                                <br/><br/>
                                <strong><small>Summary: </strong>'.$teams[$i]['summary'].'
                                <br/><br/>
                                <strong><small>Team URL: </strong><i>http://www.localhost:8888/EpiTrainer/team.php?tid='.$teams[$i]['team_id'].
                            '</i></small></td>
                            <td>
                        ';
                        
                        for($j=0; $j<count($members); $j++){
                            print '* ';
                            ProjectModel::showName($members[$j]['student_id']);
                            print '</br>';
                        }
                
                print   '
                            </td>
                            <td><a style="float:left;margin-right:15px;" href="edit-team.php?tid='.$teams[$i]['team_id'].'"><image src="images/edit.png" alt="Edit" title="Edit Summary"></a>
                        <a style="float:left;" href="edit-members.php?tid='.$teams[$i]['team_id'].'"><image src="images/edit-user.png" alt="Edit" title="Edit Users"></a></td>
                        </tr>
                        ';
            }
            
print '
            </table>
            </center>
        </div>';


include("View/footer.php");
?>
