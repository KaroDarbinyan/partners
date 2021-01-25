<?php

use yii\helpers\Url;

$this->beginBlock('head') ?>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?= $this->title ?>"/>
    <meta property="og:description"
          content="Vi lever etter vårt eget slagord: PARTNERS - Eiendomsmegleren du anbefaler videre."/>
    <meta property="og:url" content="<?= Url::current([], true); ?>"/>
    <meta property="og:image" content="<?= Url::home(true); ?>img/property-default.jpg"/>
    <meta property="og:site_name" content="PARTNERS.NO"/>
<?php $this->endBlock() ?>

<?php $this->beginBlock('page_header') ?>
<header class="header">
    <div class="container">
        <div class="page-header text-center">
            <h1 class="text-uppercase"><?= Yii::$app->view->params['header'] ?></h1>
            <h4>Vi lever etter vårt eget slagord:<br>
                PARTNERS - Eiendomsmegleren du anbefaler videre.</h4>
        </div>
        <div class="accordion dark" id="accordionSellProcess">
            <div class="card">
                <div class="card-header" id="headingBefaring">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#befaring"
                                aria-expanded="true" aria-controls="befaring">
                            <span class="point">1</span>BEFARING
                        </button>
                    </h2>
                </div>

                <div id="befaring" class="collapse show" aria-labelledby="headingBefaring"
                     data-parent="#accordionSellProcess">
                    <div class="card-body">
                        <p>
                            Partners skreddersyr den beste salgsstrategien for din bolig. Hver bolig har sine unike
                            trekk – og strategien legges etter at vi har befart boligen. På befaring kommer vi hjem til
                            deg og går gjennom boligen. Dette er viktig for å kartlegge muligheter, utfordringer og
                            finne den mest aktuelle kjøpergruppen for akkurat din bolig. På befaringen merker megleren
                            seg informasjon og detaljer som brukes senere i markedsføringen.</p>

                        <p>I etterkant skal en takstmann befare leiligheten for å gi en teknisk vurdering, samt måle opp
                            leiligheten. All denne informasjonen brukes for å lage annonse og salgsoppgave. Det vi
                            trenger fra deg er at du har klart relevant dokumentasjon om eiendommen til befaringen.
                            Dette kan være dokumentasjon på utførte arbeider i bad eller kjøkken, papirer fra rørlegger,
                            elektriker osv. Befaringen er også grunnlaget for meglers verdivurdering av eiendommen.</p>

                        <p>Etter å ha sett på flere faktorer, som prisutvikling, snittpriser i området, kvaliteter ved
                            leiligheten, beliggenhet, alder og slitasje, setter vi verdivurdering på boligen din. Tilbud
                            på salg mottar du enten på befaring eller per mail i etterkant.</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingOppdragsinngåelseAndMarkedsføring">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                data-target="#oppdragsinngåelseAndMarkedsføring" aria-expanded="false"
                                aria-controls="oppdragsinngåelseAndMarkedsføring">
                            <span class="point">2</span>OPPDRAGSINNGÅELSE <span class="d-none d-md-inline">& MARKEDSFØRING</span>
                        </button>
                    </h2>
                </div>
                <div id="oppdragsinngåelseAndMarkedsføring" class="collapse"
                     aria-labelledby="headingOppdragsinngåelseAndMarkedsføring" data-parent="#accordionSellProcess">
                    <div class="card-body">
                        <h5>Oppdragsinngåelse</h5>
                        <p>Du har nå mottatt tilbud på salg og bestemt deg for megleren som skal gjennomføre salget av
                            din bolig. For oss i Partners er det svært viktig at du som oppdragsgiver forstår fasene i
                            salgsgangen og hva det er du betaler for. Vår oppdragsavtale er satt opp i tråd med relevant
                            lovverk, samt etter retningslinjer fra forbrukermyndighetene og Norges Eiendomsmeglerforbund
                            – og er enkel å forstå. I oppdragsavtalen fastsettes betingelsene for salget,
                            meglerprovisjonen og andre utlegg.</p>

                        <h5>markedsføring</h5>
                        <p>God markedsføring er svært viktig for å nå ut til flest mulig potensielle budgivere. Din
                            Partners-megler og du som selger har det samme målet – flest mulig interessenter på visning.
                            Vi innhenter all relevant/nødvendig informasjon om boligen (kommunale avgifter,
                            reguleringskart, informasjon fra forretningsfører, grunnbokutskrift etc). Samtidig bestiller
                            vi takstmann og fotograf, mens du klargjør leiligheten for salg – dette innebærer rydding,
                            eventuelt maling, nødvendige reparasjoner o.l.</p>

                        <p>Din megler gir deg tips og anbefalinger til hva som bør gjøres før takstmann og fotograf
                            kommer innom boligen. For at vi skal kunne markedsføre din bolig på best mulig måte er det
                            avgjørende at vi har all relevant informasjon om boligen og målgruppene vi bør treffe. Vi
                            skreddersyr blant annet digital markedsføring mot kjøpegruppene som er mest aktuelle for
                            akkurat din bolig. Vi annonserer ellers i tradisjonelle nettannonser og aviser.</p>

                        <p>I tillegg har vi svært dyktige samarbeidspartnere som kan lage målstyrte digitale annonser
                            via sosiale medier eller drive direkte markedsføring. Alt etter hva som er den beste måten å
                            nå de potensielle kjøperne av din bolig. Vi tar oss av all markedsføring din bolig
                            trenger.</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingVisningAndBudrunde">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                data-target="#visningAndBudrunde" aria-expanded="false"
                                aria-controls="visningAndBudrunde">
                            <span class="point">3</span>VISNING & BUDRUNDE
                        </button>
                    </h2>
                </div>
                <div id="visningAndBudrunde" class="collapse" aria-labelledby="headingVisningAndBudrunde"
                     data-parent="#accordionSellProcess">
                    <div class="card-body">
                        <p>Før visning hjelper din megler deg med å klargjøre boligen slik at den fremstår fra sin beste
                            side. Vi gir deg gode råd og tips og følger opp interessenter som har lastet ned prospekt
                            eller kontaktet megler i forkant av visningen.</p>

                        <p>På selve visningen stiller megler opp – godt forberedt til alle spørsmål som kan komme.
                            Detaljer er viktige. Mange på visning spør megler om naboer, strømutgifter, hvorfor du
                            flytter osv. Hvis du i forkant gir megler informasjon om dette skaper dette en trygghet for
                            potensielle budgivere – som ofte gjenspeiler seg i flere budgivere – som igjen gir en ekstra
                            hyggelig salgspris.</p>

                        <p>Budrunden kan være en stressende affære både for selger og budgivere. Hos oss kan du være
                            trygg på at din megler gjør sitt beste for å få med flest mulig interessenter i budrunden,
                            slik at du oppnår maksprisen markedet er villig til å gi.</p>

                        <p>Mange på interessentlisten har vært på flere visninger og er usikre på hvilken bolig de skal
                            by på. Partners har dyktige og profesjonelle meglere som ser viktigheten av å opptre ryddig
                            og tillitsvekkende, både på visning og i budrunden, nettopp for at interessen folk har vist
                            gjenspeiler seg i bud på boligen.</p>

                        <p>I budrunden kontakter vi alle interessenter, tar imot bud og holder alle budgivere og andre
                            interessenter løpende orientert. For hvert bud holder vi også deg som selger informert via
                            SMS, slik at du følger hele prosessen tett. Du har også mulighet til å enkelt følge med på
                            budrunden i appen vår «Mitt Hjem».</p>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingKontraktsmøte">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                data-target="#kontraktsmøte" aria-expanded="false" aria-controls="kontraktsmøte">
                            <span class="point">4</span>KONTRAKTSMØTE
                        </button>
                    </h2>
                </div>
                <div id="kontraktsmøte" class="collapse" aria-labelledby="headingKontraktsmøte"
                     data-parent="#accordionSellProcess">
                    <div class="card-body">
                        <p>Når budrunden er over og boligen er solgt er neste steg kontraktsmøte. I forkant av
                            kontraktsmøtet får du oversendt utkast til kjøpekontrakt, budjournal og andre relevante
                            dokumenter. Vi finner en dato som passer deg og inviterer¬ så kjøper til kontraktsmøtet.</p>

                        <p>Her går vi gjennom kontraktene og svarer på eventuelle spørsmål og uklarheter før kontraktene
                            signeres. Dette er en formalisering av avtalen som ble gjort når budet ble akseptert. </p>

                        <p>Som i oppdragsavtalen bruker vi kjøpekontrakter som er satt opp i tråd med relevant lovverk,
                            samt etter retningslinjer fra forbrukermyndighetene og Norges Eiendomsmeglerforbund.</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingOvertagelse">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                data-target="#overtagelse" aria-expanded="false" aria-controls="overtagelse">
                            <span class="point">5</span>OVERTAGELSE
                        </button>
                    </h2>
                </div>
                <div id="overtagelse" class="collapse" aria-labelledby="headingOvertagelse"
                     data-parent="#accordionSellProcess">
                    <div class="card-body">
                        <p>Selger og kjøper møtes i boligen på overtagelsen. I forkant av dette har begge parter mottatt
                            skriftlig bekreftelse på at kjøpesum og omkostninger er mottatt på meglers klientkonto. På
                            overtagelsesdagen går dere sammen gjennom boligen og selger viser frem boder, eventuelle
                            fellesarealer m.m.</p>

                        <p>På overtagelsen skal kjøper godkjenne at boligen er ryddig og rengjort, dere leser sammen av
                            strømmåler og flytter strømabonnement. Selger overleverer samtlige nøkler til kjøper.</p>

                        <p>Det skal samtidig fylles ut og signeres en overtagelsesprotokoll. Denne kan enten fylles ut
                            fysisk (skjema utleveres på kontraktsmøtet) eller elektronisk, via en link begge parter
                            mottar per sms før overtagelsen.
                        </p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingOppgjør">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                data-target="#oppgjør" aria-expanded="false" aria-controls="oppgjør">
                            <span class="point">6</span>OPPGJØR
                        </button>
                    </h2>
                </div>
                <div id="oppgjør" class="collapse" aria-labelledby="headingOppgjør" data-parent="#accordionSellProcess">
                    <div class="card-body">
                        <p>I Partners har vi profesjonelle oppgjørsavdelinger som sørger for at alt går riktig for seg.
                            Det er store summer i sving og mange fallgruver å gå i når oppgjøret skal tas. Om noe ikke
                            er korrekt utfylt på dokumenter som skal tinglyses (skjøte, hjemmelsdokument, pantedokument
                            etc.) nekter Statens Kartverk å tinglyse – og dokumentet blir sendt i retur. Dette kan
                            forsinke oppgjøret en del – som fort kan gi ekstra kostnader til mellomfinansiering etc.</p>

                        <p>Vår svært dyktige oppgjørsavdeling sørger for at alle dokumenter er korrekt utfylt før disse
                            oversendes til tinglysing, og er særdeles effektive – slik at du som selger får oppgjøret så
                            snart som mulig.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php $this->endBlock() ?>

<?= $this->render('@frontend/views/partials/jobs.php') ?>
