# A Shopify wishlist web application

## Pre-ramble

This project has been a long time coming, on initial investigation into the Shopify API it seemed like an easy enough
tool to use. Six long months later and I do not feel the same about it.

I had grand plans of creating a Shopify SDK which other developers could use, but these plans fell to the wayside due
to mostly a lack of time. The partial SDK is included in this projects and is fully tested but I would say about 50%
complete.

While the Shopify API seems to be expansive and flexible it lacks many useful features. It seems many hacks must be
used to get the API (or the templating engine for that matter) to work as expected. This all could be due to my lack of
understanding of the product but from what I have read in the forums it is not just I to have had lost many strands
of an already sparse hairline to it's sometimes infuriating behaviour.

It is due to these facts that adding this app to a shop, the end user must do a bit of work to get the thing running.
Not too much though, all that is required is the addition of a few templates and snippets and some modifications to
the current templates.

### Caveats

#### 1. Public/private collections

I chose to use the built in collections for storing wishlist items as it seemed the most simple approach, product ids
etc would be available to the template engine... The outcome being; to use the collections the end user must filter out
any wishlist collections from any other lists of collections. Checking the link handle for the existence of the string
"wishlist-" should suffice, for example:

```html
{% if settings.use_linklist_for_categories %}
{% for link in linklists[settings.linklist_for_categories].links %}
  {% if link.handle contains 'wishlist-' %}
    <!-- Do nothing -->
  {% else if link.type == 'collection_link' %}
    {% assign collection = link.object %}
    {% include 'collection-grid-item' %}
  {% endif %}
{% endfor %}
```

#### 2. Adding templates/snippets via the API

I have been unable to find a way to install templates via the API. It is possible to add assets (page) but as it is
not possible to add a template the pages added are in effect useless.

#### 3. Retrieving the customer Id

The request passed to an application by Shopify by default does not contain the customer Id. This would be nice as it
would mean the customer Id would not have to be exposed in the actual shop. Whilst there were some hacks that could be
employed to circumvent this issue (encrypting values with a shared key is one way suggested by the Shopify community)
they felt overly complicated.

## Support

While there is a support URL supplied by the application is is pretty much a dead end. The easiest way is to
[raise an issue](https://github.com/breenie/shopify-wishlist/issues) in the
[github project](https://github.com/breenie/shopify-wishlist).

## Ongoing feature development

Whilst this project is more or less 100% feature complete I have the following in my mind; although I would prefer to
not have to implement them.

* Additional quantities of items in the wish list (you can currently have one or none)
* Various template niceties
* Modifications to the wishlist service, I don't like the way the service depends on the request (which may not always
contain a shop value). I would prefer to pass the shop value to each individual method as an argument.

## Adding the application to your shop

Visit the [application install page](http://shopify.kurl.io/wishlist/install). Enter the url for your shop and follow
the instructions. You should get a confirmation that it has been successfully installed.

### Templates

The Shopify API does not allow the addition of new templates so the required templates must be added/edited manually.
The example templates are provided as a basic default and should be modified to suit your needs.

#### The customer's wishlist page

To start with you must create a template for the new customer wishlist page. Go to "Themes" => "Template Editor". Click
"Add a new template", call this template ```page.wishlist```. As a decent enough starting point add the example template
provided. Click "save".

In the admin section of your site navigate to "Pages" and create a new page, this is going to be the page that displays
the customer's own wish list. Enter the required information as you see fit. Under "Template", select
```page.wishlist```. Click "save". This will render the wishlist page using the recently created template.

```html
<div id="col-main" class="full content">
  {% if customer %}
    {% assign wishlist_id = 'wishlist-' | append: customer.id %}
    {% assign customer_has_wishlist = false %}

    {% for collection in collections %}
      {% if customer_has_wishlist == false and collection.handle == wishlist_id %}
         {% assign customer_has_wishlist = true %}
      {% endif %}
    {% endfor %}

  <div id="page-header">
    <h2 id="page-title">
    {% if customer_has_wishlist %}
        {{ collections[wishlist_id].title }}
    {% endif %}
    </h2>
  </div>

  {% if customer_has_wishlist %}

  <table class="items">
  	<colgroup>
      <col class="checkout-image" />
      <col class="checkout-info" />
      <col class="checkout-price" />
      <col class="checkout-quantity" />
      <col class="checkout-delete" />
      <col class="checkout-delete" />
    </colgroup>

    <thead>
      <tr class="top-labels">
        <th class="empty">&nbsp;</th>
        <th>Item</th>
        <th>Price</th>
        <th>Quantity</th>
        <th class="empty">&nbsp;</th>
        <th class="empty">&nbsp;</th>
        </tr>
    </thead>

    <tbody>

        {% for product in collections[wishlist_id].products %}
      <tr class="item {{ product.handle }}">
        <td>
          <a href="{{ product.url }}">
            <img src="{{ product.featured_image | product_img_url: 'thumb' }}"  alt="{{ product.title }}" />
          </a>
        </td>
        <td><a href="{{ product.url }}">{{ product.title }}</a></td>
        <td>{{ product.price | money }}</td>
        <td>{{ difference_check }}</td>

        <td>
        {% for variant in product.variants limit:1 %}
          <form action="/cart/add" method="post">
            <input type="hidden" name="id" value="{{ variant.id }}" />
            <input class="btn" type="submit" value="Add to cart" id="addtocart" />
          </form>
        {% endfor %}
        </td>

        <td>
          <form action="/apps/wishlist/remove" method="post">
            <div id="shopify-kurl-io__wishlist--remove" style="float: right; text-align: right;">
			  <input type="hidden" id="customer_id" name="customer_id" value="{{ customer.id }}"/>
			  <input type="hidden" name="product_id" id="product_id" value="{{ product.id }}" />
			  <input type='submit' value="Remove" class="btn" />
            </div>
          </form>
        </td>
      </tr>
  {% endfor %}

    </tbody>
  </table>
  {% endif %}
  {% else %}
  <p>To create a wish list you must <a href="/account/login">sign in</a> or <a href="/account/register">create an account</a>.</p>
  {% endif %}
</div>
```

#### Adding a product to a customer's wishlist

Open ```templates/products.liquid``` or any templates that render a product and requires a wishlist button/link and add
the following:

```html
{% if customer %}
    {% assign wishlist_handle = 'wishlist-' | append: customer.id %}
    {% assign wished = false %}
    {% for collection in product.collections %}
        {% if collection.handle == wishlist_handle %}
            {% assign wished = true %}
        {% endif %}
    {% endfor %}

    {% if wished %}
        <form action="/apps/wishlist/remove" method="post">
            <div class="shopify-kurl-io__wishlist--remove" style="float: right; text-align: right;">
                <input type="hidden" id="customer_id" name="customer_id" value="{{ customer.id }}"/>
                <input type="hidden" name="product_id" id="product_id" value="{{ product.id }}" />
                <input type='submit' value="remove from wish list" class="btn" />
            </div>
        </form>
    {% else %}
        <form action="/apps/wishlist/add" method="post">
            <div class="shopify-kurl-io__wishlist--add" style="float: right; text-align: right;">
                <input type="hidden" id="customer_id" name="customer_id" value="{{ customer.id }}"/>
                <input type="hidden" name="product_id" id="product_id" value="{{ product.id }}" />
                <input type='submit' value="Add to wish list" class="btn" />
            </div>
        </form>
    {% endif %}
{% endif %}
```

### Snippets

To provide as much flexibility to the rendered templates the remote app calls render snippets that should be present in
your shop. As mentioned these snippets cannot be added via the API and must be added manually.

Creating a snippet is similar to creating a template. Go to the theme editor in your shop admin, open the "Snippets"
folder and click "Add new snippet".

#### Add to wishlist

Create a snippet called ```wishlist-added```. This is the template that will be rendered when a product is added to
the customer's wishlist.

```html
{% assign wishlist_handle = 'wishlist-' | append: customer.id %}

{% for product in collections[wishlist_handle].products %}
{% if product.id == product_id %}
<h1>Successfully added <a href="{{ product.url }}">{{ product.title }}</a> to your wishlist</h1>

<p><a href="/pages/wishlist">Go to your wishlist</a></p>
{% endif %}
{% endfor %}
```

#### Remove from wishlist

Create a snippet called ```wishlist-removed```. This is the template that will be rendered when a product is removed
from the customer's wishlist.

```html
{% assign wishlist_handle = 'wishlist-' | append: customer.id %}

{% for product in collections[wishlist_handle].products %}
{% if product.id == product_id %}
<h1>Successfully removed <a href="{{ product.url }}">{{ product.title }}</a> to your wishlist</h1>

<p><a href="/pages/wishlist">Go to your wishlist</a></p>
{% endif %}
{% endfor %}
```

#### Search wishlists

Create a snippet called ```wishlist-search```. This is the template that will be rendered when a customer searches
wishlists. The example does no tests to see if there is a user logged in, if you do not want wishlists to be public
you must add this feature.

```html
{% assign customers = customer_ids | split: ',' %}

<ul>
{% for collection in collections %}
  {% for customer_id in customers %}
    {% assign wishlist_handle = 'wishlist-' | append: customer_id %}

    {% if collection.handle == wishlist_handle %}
  <li><a href="/collections/{{ collection.handle }}">{{ collection.title }}</a></li>
    {% endif %}
  {% endfor %}
{% endfor %}
</ul>
```

## Setup instructions

Checkout the project to the directory of your choice:

```sh
$ git clone git@github.com:breenie/shopify-wishlist.git /path/to/your/directory
```

Install composer dependencies.

```sh
$ composer install --prefer-dist
```

The installer will prompt you for various defaults including Shopify API keys and secrets. Enter these and you should
along with the standard Symfony 2 parameters and you should be set.

Install the web assets.

```sh
$ app/console assets:install
$ app/console assetic:dump
```

### Update file permissions:

For systems that support setfacl

```sh
$ rm -rf app/cache/*
$ rm -rf app/logs/*
$ APACHEUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data' | grep -v root | head -1 | cut -d\  -f1`
$ sudo chmod +a "$APACHEUSER allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs
$ sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs
$ chmod -R g+swX ./
$ chown -R :$APACHEUSER ./
```

Further information can be found in the [Symfony 2 install book](http://symfony.com/doc/current/book/installation.html).

### Clear any caches

Clearing the caches cures many ills, execute the following to clear the production cache.

```
$ php app/console cache:clear --env=prod
```



