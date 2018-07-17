# The Planeswalker's Toolkit

*mtg* is a command line based tool, inspired by git and unix, for managing a Magic the Gathering card collection.

For more information run `mtg help`.

## The Concepts

Planeswalker's Toolkit tracks your card collection library with **stacks** and **binders.**

- A **stack** is an ordered list of cards, which can be appended to, and which can have cards removed from any location.  Stacks are sequentially numbered from 1 (the top face card).  Stacks never have empty slots, like a stack of cards doesn't have "missing" cards.
- A **binder** is an ordered list of cards, with each card tied to a specific numbered slot.  Cards can be removed from any slot, added to any slot, or simply added to the next available slot.

Stacks are intended to be stored in deck boxes, long card boxes, and the like.  A binder is intended to be a physical binder with card sleeve pages, with the slots for cards sequentially numbered (1 is the top left slot of the first page, 9 is the bottom right slot of the first page, 10 is the top left slot of the next page... etc.)

Storing, Removing, and Listing the contents of stacks and binders are the core features of Planeswalker's Toolkit.

Constructed decks are intended to be stored as "frozen" stacks, which track your card's existence without allowing that card to be "removed".  Constructed stacks can be unfrozen at will.

Planeswalker's Toolkit also provides the ability to **search** your library for a specific card.  You will get back a list of all locations within your collection that that card is stored, allowing you to remove that card for use.

Planeswalker's Toolkit can also manage your deck library.  In PWTK, a "deck" is simply a recipe that can be used to "summon" a fresh stack by removing cards from other stacks and binders.  There's nothing inherantly different between a "summoned" constructed deck and a stack, except that a summoned deck is "frozen" as it's intended for play.

Eventually, PWTK will be able to produce a "trade binder" of cards you would be willing to trade in a machine readable format.

## Scryfall!

PWTK uses the Scryfall API to pull data about cards and power it's internal search.  As far as PWTK's storage is concerned, cards are just Multiverse ID numbers!

Inserting a card by name requires the Scryfall API to convert that name into a specific card to insert.

More intelligent commands will allow for more intelligent insertions.

More to come!
