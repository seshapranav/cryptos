<pre><?php

$pdo = new PDO('mysql:host=sql102.epizy.com;port=3306;dbname=epiz_26764786_XXX', 'epiz_26764786', 'URNgtR7eNZobf');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt=$pdo->query("select * from users");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    echo $row['username']."\n\n";
    }
?></pre>
<h1>Hello it works</h1>