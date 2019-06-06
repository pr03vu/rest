
## Getting Started

**Requirement**

* Install [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
* Install [Vagrant](http://www.vagrantup.com/)
* Clone or [download](https://github.com/pr03vu/rest/archive/master.zip) this repository to the root folder `git clone https://github.com/pr03vu/rest`
* Run `composer install` and `vagrant up` into project folder
* Then use command `vagrant ssh` and come int code folder `cd code`
* Execute the command: `yarn install`
* Create DB `php bin/console doctrine:database:create`
* Migration `php bin/console doctrine:migrations:migrate`

## Using
To create a user, send a json file to **http://192.168.80.10/api/create-user**

Example of json file: 
```json
{
	"firstName": "John",
	"lastName": "Doe",
	"phoneNumbers": [
		"78 903 313 31",
		"78 903 313 32"
	]
}
```

Get list of users:

**http://192.168.80.10/list-users**
