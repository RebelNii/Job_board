<!--since we'll be using this div a lot(we can create a component for it and reuse multiple x)-->
<!--just like vue we make use of slots(we create a var slot inside the component card and embed slot..
.. into it so that we can wrap the card component around data   )
-->

<!--There's also a method to add more class to this component when called in another blade-->

<!-- original method with merge attr <divclass="bg-gray-50 border border-gray-200 rounded p-6">slot</div>-->

<div {{$attributes->merge(['class' => 'bg-gray-50 border border-gray-200 rounded p-6'])}} >
    {{$slot}}
</div>