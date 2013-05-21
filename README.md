# DoctrineSchemaToolL4

Laravel4でDoctrine2のSchemaToolを呼び出すartisanタスクと、

Laravel4のEloquentが利用しているコネクションを用いた、

EntityManagerを生成するaliasが利用できるパッケージです。


## インストール

1. Laravel4のルートにあるcomposer.jsonへ以下を追記します。

	```JSON
	{
		"repositories" : [
			{
				"packagist": false,
				"type": "vcs",
				"url": "https://github.com/na-apri/doctrine-schema-tool-l4.git"
			}
		],
	    "require": {
			"na-apri/DoctrineSchemaToolL4": "dev-master"
	    }
	}
	```

2. composerのupdateを行います。

		composer update


3. providerと必要であればalias登録を行います。

	app/config/app.php内のproviders配列に以下を追記します。

		'NaApri\DoctrineSchemaToolL4\DoctrineSchemaToolL4ServiceProvider',


	artisanタスクではFacadeを利用していませんので、SchemaToolのみの利用の場合は以下は必要ありませんが、

	aliasを使う場合はaliases配列に以下を追加してください。

		'Doctrine'            => 'NaApri\DoctrineSchemaToolL4\Doctrine',

4. 設定ファイルのpublishを行います。

	コンソールで以下のartisanコマンドを実行してください。

		php artisan config:publish na-apri/DoctrineSchemaToolL4
	
	コマンド実行後、app/config/na-apri/DoctrineSchemaToolL4に設定ファイルができていますので、

	このファイルを編集することで、利用するmetadeta種類とディレクトリの設定が変更できます。
	
	また、接続情報はLaravel4と同様のapp/config/database.phpのものを使い、
		
	Eloquentと同じPDOコネクションが利用されます。


## 利用方法

### artisanの追加コマンド schematool:update

	php artisan schematool:update

接続先を指定する場合はconnectionオプションで指定できます。

（app/config/database.phpの接続情報を使います。）

	php artisan schematool:update --connection=foo

エラーが出る場合は、metadataの設定を確認してください。

- ディレクトリ指定が合っているか。
- アノテーションの場合、modelがautoloadの対象になっている、もしくは読み込まれているかどうか。
- yamlの場合はテーブル名とファイル名が正しいかどうか。

etc...


### DoctrineのEntityManagerを使う。

alias登録した場合は以下のように利用します。

	$foo = Doctrine::find("FooEntity", 1);

上記の場合はdefault指定されているコネクションが利用されます。

接続先を指定する場合は以下のようにgetEntityManagerメソッドを使い、

app/config/database.phpで指定されている設定名を用いて指定してください。

	$em = Doctrine::getEntityManager('Foo');

