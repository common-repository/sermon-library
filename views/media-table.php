<script type="text/javascript">
    jQuery(document).ready(function($){

        var table = $('#wh_sermons').DataTable( {
            "order": [],
            "bLengthChange": false,
            "iDisplayLength": <?php echo $page_size; ?>,
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate,
                    type: ''
                }
            },
            columns: [
                { responsivePriority: 2 },
                { responsivePriority: 1 }
            ],
            columnDefs: [
                {
                    'targets': 'date_head',
                    'type': 'date'
                },
                {
                    'targets': 'actions_head',
                    'searchable': false,
                    'sortable': false
                }
            ],
            language: {
                searchPlaceholder: "book, title, date, teacher"
            }
        } );

        /** Scroll back to the top of the list with paging **/
        table.on('page.dt', function() {
          $('html, body').animate({
            scrollTop: $(".dataTables_wrapper").offset().top - 25
           }, 'slow');
        });

        <?php if( 'WP' == $player ): ?>
        /** Appliy media player to audio tags when redrawing the table if the player is WP **/
        table.on('draw.dt', function () {
            $('audio').mediaelementplayer();
        } );
        <?php endif; ?>

    });

</script>

<table class="wh_sermons_library" id="wh_sermons">
    <thead>
        <tr>
            <th class="date_head">Date</th>
            <th class="title_head">Title</th>
            <!--
            <th class="teacher_head">Teacher</th>
            <th class="actions_head">&nbsp;</th>
            -->
        </tr>
    </thead>
    <tbody>
        {{media_rows}}
    </tbody>
</table>
