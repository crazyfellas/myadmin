                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery the menu will break if this will be changed-->
    <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url() ?>assets/js/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url() ?>assets/js/sb-admin-2.js"></script>

    <!-- my custom scripts -->
    <script src="<?php echo base_url() ?>assets/js/locations.js"></script>

    <!-- DataTables JavaScript -->
    <script src="<?php echo base_url() ?>assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/number_format.js');?>"></script>
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });

        $('#verify_table').DataTable({
            responsive: true
        });
        
        $('#dataTables-activity, #dataTables-expenses, #dataTables-bio').DataTable({
        		responsive: true,

        });
      

    });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
    //Date picker
    $('.datepicker').datepicker({ format: 'yyyy-mm-dd',  autoclose: true });
      $('.select').select2();
    </script>

</body>

</html>
