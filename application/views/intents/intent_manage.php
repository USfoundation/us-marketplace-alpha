<?php
$udata = $this->session->userdata('user');
if(isset($orphan_cs)){
    $c['c_id'] = 0;
}
?>

<style> .breadcrumb li { display:block; } </style>
<script>
    //Define some global variables:
    var c_top_id = <?= $c['c_id'] ?>;
    var current_time = '<?= date("H:i") ?>';
    var c_outcome_max = <?= $this->config->item('c_outcome_max') ?>;
</script>
<script src="/js/custom/intent-manage-js.js?v=v<?= $this->config->item('app_version') ?>" type="text/javascript"></script>


<div class="row">
    <div class="col-xs-6 cols">
        <?php
        if(isset($orphan_cs)){

            echo '<div id="bootcamp-objective" class="list-group">';
            foreach($orphan_cs as $oc){
                echo echo_c($oc,1);
            }
            echo '</div>';

        } else {

            if(in_array($c['c_id'],$this->config->item('universal_intents'))) {
                //This is the "Get to know how Mench Personal Assistant works" tree
                //which is recommended to all new students who have not subscribed to it
                //Let the admin know about this:
                //echo '<div class="alert alert-info" role="alert" style="margin-top: 0;"><i class="fas fa-globe"></i> This is a universal intent that is automatically recommended to students</div>';
            }

            if(in_array($c['c_id'],$this->config->item('onhold_intents'))) {
                //This is the "Get to know how Mench Personal Assistant works" tree
                //which is recommended to all new students who have not subscribed to it
                //Let the admin know about this:
                echo '<div class="alert alert-info" role="alert" style="margin-top: 0;"><i class="fas fa-exclamation-triangle"></i> This intent is on-hold & not accessible to students</div>';
            }

            echo '<h5 class="badge badge-h"><i class="fas fa-sign-in-alt"></i> <span class="li-inbound-count inbound-counter-'.$c['c_id'].'">'.count($c__inbounds).'</span> Ins</h5>';

            if(count($c__inbounds)>0){
                echo '<div class="list-group list-level-2">';
                foreach($c__inbounds as $sub_intent){
                    echo echo_c($sub_intent, 2, 0, true);
                }
                echo '</div>';
            } else {
                echo '<div class="alert alert-info" role="alert" style="margin-top: 0;"><i class="fas fa-exclamation-triangle"></i> No inbound intents linked yet</div>';
            }



            echo '<h5 class="badge badge-h"><i class="fas fa-hashtag"></i> Intent</h5>';
            echo '<div id="bootcamp-objective" class="list-group">';
                echo echo_c($c,1);
            echo '</div>';








            //Expand/Contract buttons
            echo '<h5 class="badge badge-h" style="display: inline-block;"><i class="fas fa-sign-out-alt rotate90"></i> <span class="li-outbound-count outbound-counter-'.$c['c_id'].'">'.$c['c__tree_all_count'].'</span> Outs</h5>';
            echo '<div id="task_view" style="padding-left:8px; display: inline-block;">';
            echo '<i class="fas fa-plus-square expand_all" style="font-size: 1.2em;"></i> &nbsp;';
            echo '<i class="fas fa-minus-square close_all" style="font-size: 1.2em;"></i>';
            echo '</div>';
            if($orphan_c_count>0){
                echo '<div style="padding-left:8px; display: inline-block;"><a href="/intents/orphan">'.$orphan_c_count.' Orphans &raquo;</a></div>';
            }


            echo '<div id="list-c-'.$c['c_id'].'" class="list-group list-is-outbound list-level-2">';
            foreach($c['c__child_intents'] as $sub_intent){
                echo echo_c($sub_intent, 2, $c['c_id']);
            }
            ?>
            <div class="list-group-item list_input grey-block">
                <div class="input-group">
                    <div class="form-group is-empty" style="margin: 0; padding: 0;"><input type="text" class="form-control intentadder-level-2 algolia_search bottom-add"  maxlength="<?= $this->config->item('c_outcome_max') ?>" intent-id="<?= $c['c_id'] ?>" id="addintent-c-<?= $c['c_id'] ?>" placeholder="Add #Intent"></div>
                    <span class="input-group-addon" style="padding-right:8px;">
                                        <span id="dir_handle" data-toggle="tooltip" title="or press ENTER ;)" data-placement="top" class="badge badge-primary pull-right" style="cursor:pointer; margin: 1px 3px 0 6px;">
                                            <div><i class="fas fa-plus"></i></div>
                                        </span>
                                    </span>
                </div>
            </div>
            <?php
            echo '</div>';

        }
        ?>

    </div>


    <div class="col-xs-6 cols" id="iphonecol">


        <div id="modifybox" class="fixed-box hidden" intent-id="0" intent-link-id="0" level="0">

            <h5 class="badge badge-h"><i class="fas fa-cog"></i> Modify Intent</h5>
            <div style="text-align:right; font-size: 22px; margin:-32px 3px -20px 0;"><a href="javascript:void(0)" onclick="$('#modifybox').addClass('hidden')"><i class="fas fa-times-circle"></i></a></div>

            <div class="grey-box">
                <div>
                    <div class="title"><h4><i class="fas fa-bullseye-arrow"></i> Target Outcome [<span style="margin:0 0 10px 0; font-size:0.8em;"><span id="charNameNum">0</span>/<?= $this->config->item('c_outcome_max') ?></span>] <span id="hb_598" class="help_button" intent-id="598"></span></h4></div>
                    <div class="help_body maxout" id="content_598"></div>

                    <div class="form-group label-floating is-empty">
                        <div class="input-group border">
                            <span class="input-group-addon addon-lean" style="color:#2f2739; font-weight: 300;">To</span>
                            <input style="padding-left:0;" type="text" id="c_outcome" onkeyup="changeName()" maxlength="<?= $this->config->item('c_outcome_max') ?>" value="" class="form-control algolia_search">
                        </div>
                    </div>
                </div>


                <div style="margin-top:20px;">
                    <div class="title"><h4><i class="fas fa-shield-check"></i> Completion Settings</h4></div>
                    <div class="form-group label-floating is-empty">

                        <div class="radio" style="display:inline-block; border-bottom:1px dotted #999; margin-right:10px; margin-top: 0 !important;" data-toggle="tooltip" title="Intent is completed when ALL outbound intents are marked as complete" data-placement="right">
                            <label>
                                <input type="radio" name="c_is_any" value="0" />
                                <i class="fas fa-sitemap"></i> All Outs
                            </label>
                        </div>
                        <div class="radio" style="display: inline-block; border-bottom:1px dotted #999; margin-top: 0 !important;" data-toggle="tooltip" title="Intent is completed when ANY outbound intent is marked as complete" data-placement="right">
                            <label>
                                <input type="radio" name="c_is_any" value="1" />
                                <i class="fas fa-code-merge"></i> Any Out
                            </label>
                        </div>

                    </div>

                    <div class="form-group label-floating is-empty">
                        <div class="checkbox is_task">
                            <label style="display: block; font-size: 0.9em !important; margin-left:8px;"><input type="checkbox" id="c_require_notes_to_complete" /><i class="fas fa-pencil"></i> Require a written response</label>
                            <label style="display: block; font-size: 0.9em !important; margin-left:8px;"><input type="checkbox" id="c_require_url_to_complete" /><i class="fas fa-link"></i> Require URL in response</label>
                        </div>
                    </div>
                </div>


                <div style="margin-top:20px;">
                    <div class="title"><h4><i class="fas fa-box-check"></i> Completion Resources</h4></div>

                    <div class="form-group label-floating is-empty" style="max-width:150px;">
                        <div class="input-group border">
                            <span class="input-group-addon addon-lean" style="color:#2f2739; font-weight: 300;"><i class="fas fa-clock"></i></span>
                            <input style="padding-left:0;" type="number" step="1" min="0" max="300" id="c_time_estimate" value="" class="form-control">
                            <span class="input-group-addon addon-lean" style="color:#2f2739; font-weight: 300;">Minutes</span>
                        </div>
                    </div>
                    <div id="child-hours" style="margin-left:6px;"></div>

                    <div class="form-group label-floating is-empty" style="max-width:150px;">
                        <div class="input-group border">
                            <span class="input-group-addon addon-lean" style="color:#2f2739; font-weight: 300;"><i class="fas fa-usd-circle"></i></span>
                            <input style="padding-left:0;" type="number" step="0.01" min="0" max="5000" id="c_cost_estimate" value="" class="form-control">
                            <span class="input-group-addon addon-lean" style="color:#2f2739; font-weight: 300;">USD</span>
                        </div>
                    </div>
                </div>



                <table width="100%" style="margin-top:10px;">
                    <tr>
                        <td class="save-td"><a href="javascript:save_c_modify();" class="btn btn-primary">Save</a></td>
                        <td><span class="save_intent_changes"></span></td>
                        <td style="width:80px; text-align:right;">

                            <div><a href="javascript:c_unlink();" class="unlink-intent" data-toggle="tooltip" title="Only remove intent link while NOT deleting the intent itself" data-placement="left" style="text-decoration:none;"><i class="fas fa-unlink"></i> Unlink</a></div>

                            <?php if(array_key_exists(1281, $udata['u__inbounds'])){ ?>
                                <div><a href="javascript:c_delete();" data-toggle="tooltip" title="Delete intent AND remove all its links, messages & references" data-placement="left" style="text-decoration:none;"><i class="fas fa-trash-alt"></i> Delete</a></div>
                            <?php } ?>

                        </td>
                    </tr>
                </table>
            </div>

        </div>





        <div class="marvel-device iphone-x hidden" id="iphonex" intent-id="">
            <div style="font-size: 22px; margin: -5px 0 -20px 0; top: 0; right: 0px; position: absolute; z-index:9999999;"><a href="javascript:void(0)" onclick="$('#iphonex').addClass('hidden');$('#iphone-screen').html('');"><i class="fas fa-times"></i></a></div>
            <div class="notch">
                <div class="camera"></div>
                <div class="speaker"></div>
            </div>
            <div class="top-bar"></div>
            <div class="sleep"></div>
            <div class="bottom-bar"></div>
            <div class="volume"></div>
            <div class="overflow">
                <div class="shadow shadow--tr"></div>
                <div class="shadow shadow--tl"></div>
                <div class="shadow shadow--br"></div>
                <div class="shadow shadow--bl"></div>
            </div>
            <div class="inner-shadow"></div>
            <div class="screen" id="iphone-screen">
            </div>
        </div>


    </div>
</div>