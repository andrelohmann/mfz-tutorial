<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>$Title</h1>

            <% if $Tours %>
                <table class="table table-striped">
                    <tbody>
                        <% loop $Tours %>
                        <tr>
                            <th>$StartDate.Nice</th>
                            <th>$Start.Address ($StartDistance)</th>
                            <th>$Goal.Address ($GoalDistance)</th>
                        </tr>
                        <% end_loop %>
                    </tbody>
                </table>

                <% if $Tours.MoreThanOnePage %>
                <br />
                <ul class="pagination">
                    <% if $Tours.NotFirstPage %>
                    <li><a class="prev" href="$Tours.PrevLink">&lt;</a></li>
                    <% end_if %>
                    <% loop $Tours.PaginationSummary %>
                        <% if $CurrentBool %>
                        <li class="active"><a href="#">$PageNum</a></li>
                        <% else %>
                        <% if $Link %>
                        <li><a href="$Link">$PageNum</a></li>
                        <% else %>
                        <li><a href="#">...</a></li>
                        <% end_if %>
                        <% end_if %>
                    <% end_loop %>
                    <% if $Tours.NotLastPage %>
                    <li><a class="next" href="$Tours.NextLink">&gt;</a></li>
                    <% end_if %>
                </ul>
                <% end_if %>
            <% else %>
            <p><%t Tour.NOTOURSFOUND "Tour.NOTOURSFOUND" %></p>
            <% end_if %>
            $TourSearchForm
            <br />
        </div>
    </div>
</div>
