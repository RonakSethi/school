<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                         <span class="title"> <?php echo $pageHeading; ?> ---- <?php echo $bus_number['Bus']['bus_number']; ?></span>
                         <div style="padding:5px;"><?php echo $this->Html->link('<i class="fa fa-tasks">&nbsp;&nbsp;Today Report</i>', array('controller' => 'buses', 'action' => 'busmapreport', $id), array('escape' => false, 'class' => 'todo-edit','title'=>'Today Report')); ?> </div>
                         
                          <div style="padding:5px;"><?php echo $this->Html->link('<i class="fa fa-tasks">&nbsp;&nbsp;Yesterday Report</i>', array('controller' => 'buses', 'action' => 'busmapreport', $id,'yesterday'), array('escape' => false, 'class' => 'todo-edit','title'=>'Yesterday Report')); ?> </div>
                          
                          <div style="padding:5px;"><?php echo $this->Html->link('<i class="fa fa-tasks">&nbsp;&nbsp;Weekly Report</i>', array('controller' => 'buses', 'action' => 'busmapreport', $id,'weekly'), array('escape' => false, 'class' => 'todo-edit','title'=>'Weekly Report')); ?> </div>
                          <br /><br />
                         
                         	<div>
                             <iframe src="http://54.149.95.196/busmap.php?id=<?php echo $id;?>&m=<?php echo $m;?>" width="100%" height="700px">
                            </div>


                    
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>
