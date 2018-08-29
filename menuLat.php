<!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
<!--                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo BASE_URL;?>dist/img/avatar5.jpg" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $nombre ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>-->
                    <ul class="sidebar-menu" data-widget="tree">
                         <!--<li class="header text-center" style="font-weight: 600;"> MENÚ</li>-->
                        <!--<li class="header text-center" style="font-weight: 600;"> MENÚ </li>-->
                        <?php
                                                       
                            $execue=sqlsrv_query($conn,$query);
                            $carpeta="";
                            while($row=sqlsrv_fetch_array($execue)){
                                if($carpeta == $row['CARPETA']){ ?>
                                 
                                    <li><a href="<?php echo BASE_URL.$row['CARPETA'].'/'.$row['ARCHIVO'] ?>"><i class="fa <?php echo $row['ICONO']; ?> text-aqua"></i> <span><?php echo utf8_encode($row['MODULO']); ?></span></a></li>
                                <?php                                 
                                    }else{ 
                                ?>
                                    <li class="header text-center" style="font-weight: 600;"><?php echo $row['CARPETA'];?></li>
                                    <li><a href="<?php echo BASE_URL.$row['CARPETA'].'/'.$row['ARCHIVO'] ?>"><i class="fa <?php echo $row['ICONO']; ?> text-aqua"></i> <span><?php echo utf8_encode($row['MODULO']); ?></span></a></li>
                                <?php }
                                $carpeta = $row['CARPETA'];
                            }
                        ?>                   -->
                        
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>