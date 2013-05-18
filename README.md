# DoctrineSchemaToolL4


Laravel4でDoctrineのSchemaToolを使いたい的な奴です。

実在するModelがなくてもMetadataを無理矢理に作る感じなので、

アノテーション指定以外にもxml(動かしてないけどコードはある)と、

yamlのみでのSchemaTool:updateができます。

テスト誰か書いて！

他にはDoctrineのEntityManagerが返ってくるFacadeがあります。

使ってないのでよくわかりませんがfindは動きました。


## インストール

### Composerを使う方法

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

composer.jsonに上記を追加して、

	composer update

で落ちてきます。

app/config/app.phpの中にある、

providers配列に、

	'NaApri\DoctrineSchemaToolL4\DoctrineSchemaToolL4ServiceProvider',

Facadeも使いたい場合はaliases配列に、

	'Doctrine'            => 'NaApri\DoctrineSchemaToolL4\Doctrine',

を追加してください。

### 設定ファイル

publishを行います。

	php artisan config:publish na-apri/DoctrineSchemaToolL4
	

app/config/na-apri/DoctrineSchemaToolL4に設定ファイルが出来ているので、

そこで設定を変更できます。


## 使い方

### artisanの追加コマンド schematool:update

	php artisan schematool:update

接続先を指定する場合はconnectionオプションで指定できます。

（app/config/database.phpの接続情報を使います。）

	php artisan schematool:update --connection=foo


### DoctrineのEntityManagerを使う。

Facadeがある場合は、

	$foo = Doctrine::find("FooEntity", 1);

みたいに使えます。

また、接続先を指定する場合は、

	$em = Doctrine::getEntityManager('Foo');

で指定して取得できます。

