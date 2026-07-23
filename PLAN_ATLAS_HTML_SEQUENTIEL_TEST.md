# PLAN — Atlas : modes « Séquentielle » et « Test » pilotés par le HTML de la figure

> **Objectif** : quand une figure possède un HTML autonome (`figures.htmlContent`), les modes
> **Légende séquentielle** et **Test** ne retombent plus sur les rangées classiques
> (`textGauche` / `textDroite`) mais s'appuient sur le HTML lui-même — **en reproduisant
> exactement le comportement classique existant**, pas un nouveau parcours :
>
> - **Comportement identique à aujourd'hui** : les légendes sont découpées en **groupes de 4**,
>   et **chaque groupe est recouvert de SON bouton « Découvrir la réponse »**. **Tous les
>   boutons sont affichés en même temps** ; l'utilisateur clique celui qu'il veut, dans
>   l'ordre qu'il veut, et ce groupe-là se dévoile. C'est le fonctionnement des
>   `.legend-group-row` + `.btn-corriger` des figures classiques (cf. capture n°2).
> - **PAS de parcours pas-à-pas** : pas de barre de progression, pas de compteur « 1 / 2 »,
>   pas de bloc « courant » unique avec les suivants grisés, pas d'avance automatique au bloc
>   suivant. Cette approche (capture n°1) est **abandonnée**.
> - HTML avec **une seule image** → toutes les légendes forment une seule suite découpée
>   par 4 (4 + 4 + reste), comme aujourd'hui.
> - HTML avec **plusieurs images** → **seule différence apportée par ce plan** : la division
>   par 4 est **scopée par titre de figure** et **repart à zéro à chaque titre**. Un groupe
>   de 4 n'est jamais à cheval sur deux images.
> - **Respect intégral de la charte graphique du HTML** (couleurs, CSS de l'export) :
>   le masque/bouton se superpose au texte-réponse, il ne repeint jamais les couleurs de
>   l'export (badges, items de légende, marqueurs, titres).

---

## 1. État actuel (rappel)

| Élément | Où | Comportement actuel |
|---|---|---|
| Page Atlas | `application/views/v1_listCalqueFigure.php` | 3 modes : Complète (`.adMode`), Séquentielle (`.restoreNormalMode`), Test (`.beginTest`) |
| HTML autonome | Endpoint `Home::atlasFigureHtml($idFigure)` (`Home.php:10037`) | Servi à la demande, mis en cache (ETag), rendu dans un **Shadow DOM** (`.atlas-html-host`) |
| Séquentielle **classique** (référence à reproduire) | `.legend-group-row` (vue, l.461 / l.521) | Un groupe = 4 légendes (`$figure['textGauche']` est déjà un tableau de blocs) ; un `<button class="btn btn-success btn-corriger">` en `position:absolute` **recouvre tout le groupe** ; `afficheReponseBlock()` masque ce bouton → les 4 réponses apparaissent. **Tous les boutons coexistent.** |
| Test **classique** (référence à reproduire) | `.beginTest` (vue, l.815) | Les boutons de groupe sont masqués, **toutes** les saisies (`.rond` œil + `textarea`) sont affichées d'un coup, les réponses sont masquées ; l'œil affiche la réponse en toast (`showToast`) |
| Contrat du HTML | `_sample_figure_html.html` | Chaque légende **et** chaque marqueur porte `data-num="N"` ; styles dans un `<style>` embarqué ; `<img>` masquée servant à la miniature |

Le problème initial : pour une figure HTML, Séquentielle et Test utilisaient les légendes texte
extraites (`textGauche`/`textDroite`), qui ne reflètent ni le contenu ni le style du HTML.

**Ce qui est à corriger dans l'implémentation actuelle (branche en cours)** : elle a introduit
un parcours séquentiel bloc-par-bloc avec barre de progression — non désiré (cf. §4.0).

---

## 2. Stratégie de lecture du HTML

### 2.1 Détection du nombre d'images et des titres
*(inchangé — cette partie de l'analyse est correcte et conservée)*

Après injection du HTML dans le Shadow DOM, `atlasAnalyzeFigure(shadowRoot)` :

1. Compte les **panneaux schéma visibles** : les `<svg>` + les `<img>` **non masquées**
   (on exclut l'`<img style="display:none">` réservée à l'extraction de miniature).
2. Récupère le **titre** de chaque image : `.titre-figure` (contrat de l'exemple),
   `.aa-title` / `.aa-subtitle` (exports `aa-*`), ou le premier titre textuel du conteneur.
3. `count <= 1` → **un seul groupe implicite** ; `count > 1` → **groupes par titre**.

### 2.2 Rattachement légendes ↔ titre/image (multi-images)
*(inchangé)*

Ordre de résolution (du plus fiable au fallback) :

1. **Attribut de contrat `data-fig="K"`** sur les items de légende (et sur le titre) →
   rattachement explicite.
2. **Structure DOM** : la section qui contient une image, son titre et sa liste de légendes.
3. **Fallback par ordre d'apparition** : l'item est rattaché au panneau le plus proche.

### 2.3 Découpage en groupes de 4 (statique, tous affichés)

Le résultat de l'analyse est une **liste de groupes de 4**, tous rendus en même temps :

```
mono-image (1 titre implicite, 9 légendes) :
    [1,2,3,4]  [5,6,7,8]  [9]           ← 3 boutons « Découvrir la réponse » simultanés

multi-images (titre A : 6 légendes, titre B : 5 légendes) :
    Titre A : [1,2,3,4]  [5,6]          ← la division par 4 s'arrête à la fin du titre A
    Titre B : [1,2,3,4]  [5]            ← elle REPART à zéro au titre B
                                           → 4 boutons simultanés au total
```

Règles :
- Le découpage par 4 est **scopé par titre** : compteur remis à zéro à chaque titre, jamais
  de groupe à cheval sur deux titres.
- Le dernier groupe d'un titre peut contenir 1 à 3 items (reste de la division).
- **Aucun ordre imposé** : les groupes sont indépendants, on peut en découvrir un au milieu.

---

## 3. Comportement cible par mode

### 3.1 Légende complète — inchangé
HTML complet dans le Shadow DOM, clic `data-num` → surlignage rouge. Aucune modification.

### 3.2 Légende séquentielle (HTML) — copie du comportement classique

- Le HTML reste affiché (image + marqueurs + **CSS d'origine**).
- Pour **chaque groupe de 4** (§2.3), on injecte dans le Shadow DOM un conteneur
  `.atlas-group` en `position:relative` autour des items du groupe, plus un
  **bouton-masque `.atlas-reveal` en `position:absolute` qui recouvre le groupe**, libellé
  « Découvrir la réponse » (`decouv_respons`).
- **Tous les boutons de tous les groupes sont visibles simultanément** — état initial :
  aucun groupe découvert.
- Clic sur un bouton → **ce bouton disparaît** (`display:none`), les 4 réponses de son groupe
  redeviennent visibles et cliquables (`data-num` → surlignage rouge). Les autres groupes
  restent couverts. Strictement le comportement de `afficheReponseBlock()`.
- **Rien d'autre** : pas de barre, pas de compteur, pas d'ordre, pas d'enchaînement auto.
- **Multi-images** : les titres des images restent visibles (ils font partie du HTML, ce ne
  sont pas des réponses) ; ils délimitent simplement les groupes.

### 3.3 Test (HTML) — copie du comportement classique

- Les boutons-masques `.atlas-reveal` sont **masqués** (comme `btn-gauche`/`btn-droite` en
  test classique).
- Le texte de chaque légende est masqué et remplacé, **pour toutes les légendes en même
  temps**, par : le **badge numéro du HTML** (style de l'export conservé) + une **icône œil**
  (réponse en toast via `showToast`) + un **champ de saisie**.
- Le découpage par 4 sert uniquement de **regroupement visuel** (les groupes restent des
  conteneurs) ; il n'y a **pas** de bouton « Corriger » par bloc ni de progression — le test
  classique de l'Atlas n'en a pas. *(Choix validé : le Test reste calqué sur le classique.)*
- Les saisies ne sont pas persistées (identique au test classique actuel).

### 3.4 Conservation de la charte graphique du HTML

- Le `<style>` embarqué de l'export est **conservé tel quel** dans le Shadow DOM.
- Le style du masque/bouton est injecté dans un `<style>` **additionnel ajouté après** celui
  de l'export : il ne cible **que** les classes `.atlas-group` / `.atlas-reveal` /
  `.atlas-answer` et ne redéfinit **aucune** couleur ni typo de l'export (badges, items,
  marqueurs, titres restent tels que dessinés dans le HTML).
- Le masque **recouvre** la zone du texte-réponse (calque au-dessus) au lieu de repeindre les
  éléments : rien du HTML n'est modifié visuellement en dessous.
- Le bouton reprend exactement le vert `.btn-corriger` de l'application (`#86C4AF`, texte
  vert, survol `rgb(9,138,99)`) pour rester identique au comportement classique ; il est
  **opaque** (il masque proprement badges et texte) et **disparaît** au clic, laissant
  réapparaître le HTML avec ses couleurs d'origine.
- Aucun nœud n'est retiré : le retour au mode Complète est un simple retrait de classes.

---

## 4. Étapes d'implémentation

### Étape 0 — Retirer le parcours pas-à-pas déjà écrit *(nouveau)*
À supprimer de `v1_listCalqueFigure.php` :
- le bloc HTML `.atlas-progress-bar` (titre / compteur / bouton d'action) et son CSS
  (`.atlas-progress-bar`, `.atlas-progress-title`, `.atlas-progress-count`,
  `.atlas-progress-action`) ;
- le moteur de curseur : `host._cursor`, `atlasAdvance()`, `atlasBarOf()`, la partie
  « barre » de `atlasRender()` ;
- les états `atlas-item-current` (contour pointillé bleu) et `atlas-item-future`
  (opacité 0.4) — ils n'ont plus lieu d'être.
Conservé : `atlasAnalyzeFigure()` et tout le §2 (analyse images/titres/groupes),
`atlasWrapAnswer()`, `atlasEnsureInput()`, le chargement/Shadow DOM, le repli classique.

### Étape 1 — Aiguillage des 3 modes *(déjà fait, conservé)*
`atlasApplyHtmlMode(mode)` avec `mode ∈ {'complete', 'sequential', 'test'}` ; pour une figure
`hasHtml === '1'`, les 3 modes affichent le host HTML et masquent `.atlas-classic-row`.
Figure sans HTML : comportement classique strictement inchangé.

### Étape 2 — Analyse du HTML → groupes de 4 scopés par titre *(déjà fait, conservé)*
`atlasAnalyzeFigure(shadowRoot)` → `{ groups: [{label, items[]}], blocks: [{titleIndex, items[]}] }`.
Mémorisé sur le host (`host._analysis`), calculé une fois par figure.
Si aucun `[data-num]` → repli sur les rangées classiques (aucune page cassée).

### Étape 3 — Rendu des groupes + boutons-masques *(remplace l'ancien « moteur de progression »)*
- À la première bascule en Séquentielle/Test : pour chaque groupe, envelopper ses items dans
  un `.atlas-group` (`position:relative`) et y insérer un `<button class="atlas-reveal">`.
  Enveloppement **idempotent** (fait une seule fois par figure, réutilisé ensuite).
- État par groupe : `revealed` (bouton masqué) / `covered` (bouton visible).
- Retour en mode Complète ou changement de figure → tous les groupes remis à `covered`
  (les boutons réapparaissent), texte de nouveau visible en Complète.

### Étape 4 — Mode Séquentielle
- Boutons `.atlas-reveal` visibles, réponses masquées sous le masque.
- Clic → masque son propre bouton uniquement (aucun effet sur les autres groupes).

### Étape 5 — Mode Test
- Boutons `.atlas-reveal` masqués ; pour **tous** les items : badge + œil + `<input>`.
- Œil → `showToast()` : le toast vit dans le document principal, pas dans le Shadow DOM —
  passerelle déjà en place (listener dans le shadow appelant la fonction globale).

### Étape 6 — Boutons de mode & réinitialisation
- Branchement inchangé sur `.adMode`, `.restoreNormalMode`, `.beginTest` (après les
  gestionnaires historiques, qui ne concernent visuellement que les figures sans HTML).
- Changement de mode ou de figure → tous les groupes recouverts, saisies vidées.
  `afficheFigure()` conserve le retour au mode par défaut « Légende complète ».

### Étape 7 — Contrat & exemple
- `_sample_figure_html.html` : documenter l'attribut optionnel `data-fig`.
- `_sample_figure_html_multi.html` : exemple **multi-images avec titres** pour vérifier la
  remise à zéro du découpage par 4 à chaque titre.

---

## 5. Fichiers touchés

| Fichier | Nature du changement |
|---|---|
| `application/views/v1_listCalqueFigure.php` | **Principal** — suppression de la barre de progression et du curseur, rendu des groupes de 4 + boutons-masques dans le Shadow DOM, styles additionnels `.atlas-group` / `.atlas-reveal` |
| `_sample_figure_html.html` / `_sample_figure_html_multi.html` | Contrat `data-fig` + exemple multi-images avec titres |
| `application/controllers/Home.php` | **Aucun changement** (`atlasFigureHtml` sert déjà le HTML brut) |
| `application/views/v1_bloc_figures.php` (viewer livreCours) | **Hors périmètre** de ce plan (Atlas uniquement) |

---

## 6. Cas limites & garde-fous

- Nombre de légendes non multiple de 4 → dernier groupe du titre à 1–3 items (normal).
- Titre ne contenant que 1 à 3 légendes → un seul groupe pour ce titre.
- HTML sans `[data-num]` → repli rangées classiques (aucune page cassée).
- Échec de chargement du HTML → repli classique déjà en place (conservé).
- Légendes d'un même titre non contiguës dans le DOM → le `.atlas-group` enveloppe la plage
  contiguë ; si la plage est discontinue, on scinde en plusieurs masques du même groupe
  (même comportement de révélation : un clic découvre les 4 items du groupe).
- Marqueurs `data-num` dans le SVG → **jamais masqués** (ce sont les questions) ; ils suivent
  seulement le surlignage rouge de leur numéro.
- Sous-listes / numérotation romaine (`aa-roman-*`) : seuls les porteurs de `data-num`
  comptent comme réponses ; le reste demeure visible (contexte).
- Images sans titre détectable → groupe de repli « #K » (division par 4 scopée sur l'image).
- Changement de figure en cours de découverte → réinitialisation (pas de persistance, assumé).

---

## 7. Validation prévue

1. Figure HTML **mono-image**, 9 légendes → **3 boutons** « Découvrir la réponse » affichés
   simultanément (`[1-4]`, `[5-8]`, `[9]`) ; cliquer le 2ᵉ ne découvre que le 2ᵉ.
2. Figure HTML **multi-images avec titres** (titre A = 6 légendes, titre B = 5) → **4 boutons**
   simultanés `A[1-4]`, `A[5-6]`, `B[1-4]`, `B[5]` : vérifier que le découpage **repart à zéro
   au titre B** et qu'aucun groupe n'est à cheval sur deux titres.
3. Vérifier visuellement que les **couleurs/CSS de l'export sont intacts** dans les 3 modes
   (badges, items, marqueurs, titres) et que le masque ne fait que recouvrir.
4. Mode Test : toutes les saisies apparaissent d'un coup, aucun bouton-masque visible, œil →
   toast avec la bonne réponse.
5. Bascule Complète → Séquentielle → Test → Complète sans rechargement (masques réinitialisés),
   puis changement de miniature (retour au mode par défaut).
6. Figure **sans** HTML : comportement classique strictement identique à aujourd'hui
   (capture n°2 comme référence).
