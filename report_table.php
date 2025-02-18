<?php if ($reportTitle): ?>
    <h2><?= $reportTitle ?></h2>
    <?php if ($reportType === 'total_complaints' && count($reportData) > 0): ?>
        <p><strong>Total Complaints Submitted:</strong> <?= $reportData[0]['total'] ?></p>
    <?php elseif (count($reportData) > 0): ?>
        <div id="reportContent">
            <table>
                <thead>
                    <tr>
                        <?php foreach (array_keys($reportData[0]) as $header): ?>
                            <th><?= ucfirst(str_replace('_', ' ', $header)) ?></th>
                            <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reportData as $row): ?>
                        <tr>
                            <?php foreach ($row as $value): ?>
                                <td><?= htmlspecialchars($value) ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>
                </tbody>
            </table>
        </div>
                <button onclick="printReport()" style="margin: 10px 0; padding: 10px 20px; background-color: #28a745; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Print Report</button>
        <script>
            function printReport() {
                const reportContent = document.getElementById('reportContent').innerHTML;
                const printWindow = window.open('', '', 'height=600,width=800');
                printWindow.document.write('<html><head><title>Print Report</title>');
                printWindow.document.write('<style>table {width: 100%; border-collapse: collapse;} th, td {border: 1px solid #000; padding: 10px; text-align: left;} th {background-color: #007bff; color: #fff;} h2 {text-align: center; margin-bottom: 20px;}</style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write('<h2><?= $reportTitle ?></h2>');
                printWindow.document.write(reportContent);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            }
        </script>
    <?php else: ?>
        <p class="no-data">No data available for this report.</p>
    <?php endif; ?>
<?php endif; ?>
