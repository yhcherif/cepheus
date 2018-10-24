@extends("layouts.app")

@section("content")
<div class="py-8">
    <div class="flex flex-col items-center">
        <h2 class="text-xl font-sans text-grey-darker mb-2 px-4 text-center">Offrez un réseau d'achat de médicaments à travers tout le pays</h2>

        <div class="flex py-6">
            <img src="/img/country_drugs.svg" alt="" class="">
        </div>

        <div class="flex mb-6">
            <a href="{{ route('transaction.create') }}" class="px-8 py-4 bg-primary text-white shadow-md no-underline rounded">Créer un panier partagé</a>
        </div>

        <p class="mb-6 font-bold font-sans text-grey-dark">- OU -</p>

        <div class="flex mb-6">
            <a href="#" class="px-8 py-4 bg-secondary text-white shadow-md no-underline rounded">Finaliser un panier en cours</a>
        </div>

        <div class="flex flex-col items-center justify-center">
            <h4 class="text-midnight mb-2 font-light font-sans">Instructions</h4>
            <p class="text-center max-w-lg text-midnight font-sans font-light text-sm">Un code ainsi que le montant total de la transaction est envoyé à la tierce personne qui effectuera le paiement. Cette personne devra présenter ce code auprès d'une phramacie agrée SANTE EXPRESS dans un délai de 24 heures.</p>
        </div>
    </div>
</div>
@stop
