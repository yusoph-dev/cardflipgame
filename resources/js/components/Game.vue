<template>
<!-- Background Music -->

<audio ref="backgroundMusic" loop>
    <source :src="backgroundMusicSrc" type="audio/mp3">
    Your browser does not support the audio element.
</audio>

<audio ref="easyModeSound" loop>
    <source :src="easyModeSoundSrc" type="audio/mp3">
    Your browser does not support the audio element.
</audio>
<audio ref="averageModeSound" loop>
    <source :src="averageModeSoundSrc" type="audio/mp3">
    Your browser does not support the audio element.
</audio>
<audio ref="hardModeSound" loop>
    <source :src="hardModeSoundSrc" type="audio/mp3">
    Your browser does not support the audio element.
</audio>
<audio ref="impossibleModeSound" loop>
    <source :src="impossibleModeSoundSrc" type="audio/mp3">
    Your browser does not support the audio element.
</audio>

<!-- Flip Card Sound -->
<audio ref="flipCardSound">
    <source :src="flipSoundSrc" type="audio/mp3">
    Your browser does not support the audio element.
</audio>

<!-- correct Card Sound -->
<audio ref="correctSound">
    <source :src="correctSoundSrc" type="audio/mp3">
    Your browser does not support the audio element.
</audio>

<!-- ErrorFlip Card Sound -->
<audio ref="errorFlipCardSound">
    <source :src="errorFlipSoundSrc" type="audio/mp3">
    Your browser does not support the audio element.
</audio>

<!-- Finish Game Sound -->
<audio ref="finishGameSound">
    <source :src="finishGameSoundSrc" type="audio/mp3">
    Your browser does not support the audio element.
</audio>

<div id="initial" v-if="initial" class="container">
    <div class="row pmobile">
        <div class="text-center col-md-8 deck maindeck">
            <h1 class="nablafont p-4">FlipMaster Challenge</h1>
            <div class="p-4">
                <h5 class="text-white">Embark on a thrilling journey of memory and strategy with FlipMaster Challenge, a captivating card flipping game that tests your concentration and memory skills! Dive into the challenge of pairing matching cards while aiming for the top of the leaderboard.</h5>
            </div>
            <button class="play-button btn btn-danger" @click="hideInitial" v-if="hasSession == false"> <img :src="'images/card.png'" alt="Back image" id="play-img"> Play</button>
            <button class="play-button btn btn-danger" @click="hideInitial" v-else> <img :src="'images/card.png'" alt="Back image" id="play-img"> Continue</button>
        </div>
    </div>
</div>
<div id="my-container" v-if="!initial">
    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none" v-if="difficulty == null">
                    <img class="bi me-2" width="32" height="32" role="img" aria-label="Bootstrap" :src="'images/pokeball.png'">
                </a>

                <!-- <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="#" class="nav-link px-2 text-yellow"></a></li>
                    </ul> -->

                <form v-if="difficulty > 0" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li style="border: 3px solid transparent; font-weight: 600;"><span class="nav-link px-2 text-white">NO. OF TURNS : {{ count }}</span></li>
                    </ul>
                </form>

                <div v-if="difficulty > 0" class="text-end">
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li style="border: 3px solid transparent; font-weight: 600;"><button @click="resetGame" class="nav-link px-2 btn btn-danger text-white">RESET</button></li>
                        <li style="border: 3px solid transparent; font-weight: 600;"><span class="nav-link px-4 text-white nablafont">{{ formattedTime }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <div class="container" v-if="difficulty == null">
        <div class="row p-4">
            <h2>Player Name</h2>
            <div class="btn-group btn-group-toggle form-group" data-toggle="buttons">
                <input type="text" class="form-control" v-model="playerName" @input="limitInput">
            </div>
        </div>
        <div class="row p-4">
            <h2>Select Difficulty</h2>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <button @click="setDifficulty(1)" type="button" class="btn btn-success btn-lg">EASY</button>
                <button @click="setDifficulty(2)" type="button" class="btn btn-primary btn-lg">AVERAGE</button>
                <button @click="setDifficulty(3)" type="button" class="btn btn-warning btn-lg text-dark">HARD</button>
                <button @click="setDifficulty(5)" type="button" class="btn btn-danger btn-lg">IMPOSSIBLE</button>
            </div>
        </div>
        <div class="row p-4 rankings" v-if="(rankings.length > 0)">
            <h2>Player Rankings</h2>
            <div class="container">
                <table class="table table-dark table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">Name</th>
                            <th class="text-center" scope="col">Flips</th>
                            <th class="text-center" scope="col">Time</th>
                            <th class="text-center" scope="col">Difficulty</th>
                            <th class="text-center" scope="col">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(player, index) in rankings" :key="player.id">
                            <th class="text-center" scope="row">{{ index + 1 }}</th>
                            <td class="text-center">{{ player.name }}</td>
                            <td class="text-center">{{ player.flips }}</td>
                            <td class="text-center">{{ player.seconds }}</td>
                            <td class="text-center">
                                <span v-if="player.difficulty == 1" class="badge bg-success">EASY</span>
                                <span v-if="player.difficulty == 2" class="badge bg-primary">AVERAGE</span>
                                <span v-if="player.difficulty == 3" class="badge bg-warning text-dark">HARD</span>
                                <span v-if="player.difficulty == 5" class="badge bg-danger">IMPOSSIBLE</span>
                            </td>
                            <td class="text-center nablafont">{{ player.points  }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container" v-if="difficulty != null" v-bind:class="{'easy-deck': (difficulty == 1)}">
        <div class="row deck">
            <template v-for="(item, index) in randomCards" :key="item">

                <div class="flip-card p-1 " v-bind:class="{'col-md-3': (difficulty == 1), 'col-xs-3': (difficulty == 1), 'col-md-2': (difficulty == 2 ), 'col-md-1': (difficulty > 2 && difficulty < 6), 'col-xs-2': (difficulty > 1 && difficulty < 6) }" v-on:click="flipCard(index)">
                    <div class="card card-inner" v-bind:class="{flipped: item.opened, 'notflipped': (!item.opened)}">
                        <div class="card card-front">
                            <img :src="'images/cards/0.png'" alt="Front image">
                        </div>
                        <div class="card card-back">
                            <img :src="'images/cards/'+item.card_id+'.webp'" alt="Back image" v-bind:class="{'darken-image': (item.freezed)}">
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Vertically centered modal -->
    <div class="modal fade modal-dialog modal-dialog-centered" id="congratsModal" v-bind:class="{ 'show': showModal }">
        <div class="modal-content maindeck">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalCenterTitle">CONGRATULATIONS</h4>
            </div>
            <div class="modal-body">
                <h3>{{ playerName }}</h3>
                <h3>Total score is: <span class="nablafont">{{ totalScore }}</span> </h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" @click="closeModal">RESET</button>
            </div>
        </div>
    </div>

    <footer class="d-flex bg-dark text-white flex-wrap justify-content-between align-items-center py-3 ">
        <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                <svg class="bi" width="30" height="24">
                    <use xlink:href="#bootstrap"></use>
                </svg>
            </a>
            <span class="text-white">© 2024 Yusoph Flip Card MINI GAME</span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                        <use xlink:href="#twitter"></use>
                    </svg></a></li>
            <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                        <use xlink:href="#instagram"></use>
                    </svg></a></li>
            <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                        <use xlink:href="#facebook"></use>
                    </svg></a></li>
        </ul>
    </footer>
</div>
</template>

<script>
export default {
    el: '#my-container',
    name: "app",
    data() {
        return {
            backgroundMusicSrc: "audio/bg.mp3",
            flipSoundSrc: "audio/cardflip.mp3",
            errorFlipSoundSrc: "audio/errorflip.mp3",
            correctSoundSrc: "audio/correct.mp3",
            finishGameSoundSrc: "audio/levelwin.mp3",

            easyModeSoundSrc: "audio/easy.mp3",
            averageModeSoundSrc: "audio/average.mp3",
            hardModeSoundSrc: "audio/hard.mp3",
            impossibleModeSoundSrc: "audio/impossible.mp3",

            initial: true,
            count: 0,
            active: true,
            showCard: false,
            difficulty: null,
            cards: 0,
            randomCards: [],
            matchedCards: 0,
            firstCard: null,
            verifying: false,
            playerName: 'Player',
            timerSeconds: 0,
            totalScore: 0,
            timerInterval: null,
            showModal: false,
            rankings: [],

            hasSession: false,
            sessionData: [],
        };
    },

    computed: {
        formattedTime() {
            const minutes = Math.floor(this.timerSeconds / 60);
            const seconds = this.timerSeconds % 60;
            return `${this.formatTime(minutes)}:${this.formatTime(seconds)}`;
        },
    },
    mounted() {
        this.getSession();
        this.getRankings();
    },
    methods: {
        hideInitial() {
            if(!this.hasSession){
                this.initial = false;
                this.resetGame();
            }else{

                this.initial = (this.sessionData.initial == 0) ? false : true;
                this.count = this.sessionData.count;
                this.active = (this.sessionData.active == 0) ? false : true;
                // this.showCard = this.sessionData.initial;
                this.difficulty = this.sessionData.difficulty;
                this.cards = this.sessionData.cards;
                this.randomCards = this.sessionData.random_cards;
                this.matchedCards = this.sessionData.matched_cards;
                this.firstCard = this.sessionData.first_card;
                this.verifying = false;
                this.playerName = this.sessionData.player_name;
                this.timerSeconds = this.sessionData.timer_seconds;
                this.totalScore = this.sessionData.total_score;
                this.timerInterval = this.sessionData.timer_interval;
                this.showModal = false;
                this.startTimer();
            }
        },
        getSession() {
            axios.get('/session')
                .then(response => {
                    this.hasSession = true;
                    this.sessionData = response.data.session;

                    console.log(this.sessionData)
                })
                .catch(error => {
                    if (error.response && error.response.status === 404) {
                        // Handle 404 error
                        console.log('Resource not found.');
                    } else {
                        // Handle other errors
                        console.error('An error occurred:', error.message);
                    }
                });
        },
        getRankings() {
            axios.get('/rankings')
                .then(response => {
                    this.rankings = response.data.rankings;
                    this.playerName = 'Player' + this.rankings.length;
                })
                .catch(error => {
                    console.error('Error fetching rankings:', error);
                });
        },
        saveSession() {
            axios.post('postSession', {
                initial: this.initial,
                count: this.count,
                active: this.active,
                showCard: this.showCard,
                difficulty: this.difficulty,
                cards: JSON.stringify(this.cards),
                random_cards: JSON.stringify(this.randomCards),
                matched_cards: this.matchedCards,
                first_card: JSON.stringify(this.firstCard),
                verifying: this.verifying,
                player_name: this.playerName,
                timer_seconds: this.timerSeconds,
                total_score: this.totalScore,
                timer_interval: this.timerInterval,
                show_modal: this.showModal,
            })
            .then((response) => {

            })
            .catch((error) => {

            })
        },
        setDifficulty(selected) {

            if (this.playerName != null) {

                this.difficulty = selected;

                // easy mode
                if (this.difficulty == 1) {
                    this.cards = (4 * 2);

                    const easyModeSound = this.$refs.easyModeSound;
                    easyModeSound.volume = 0.5; // Set volume to 50%
                    easyModeSound.play();
                }

                // average mode
                if (this.difficulty == 2) {
                    this.cards = (6 * 3);

                    const averageModeSound = this.$refs.averageModeSound;
                    averageModeSound.volume = 0.5; // Set volume to 50%
                    averageModeSound.play();
                }

                // hard mode
                if (this.difficulty == 3) {
                    this.cards = (6 * 8);

                    const hardModeSound = this.$refs.hardModeSound;
                    hardModeSound.volume = 0.5; // Set volume to 50%
                    hardModeSound.play();
                }

                // impossible mode
                if (this.difficulty == 5) {
                    this.cards = (12 * 8);

                    const impossibleModeSound = this.$refs.impossibleModeSound;
                    impossibleModeSound.volume = 0.5; // Set volume to 50%
                    impossibleModeSound.play();
                }

                var cards = [];

                //generate cards available numbers
                for (let i = 0; i < (this.cards / 2); i++) {

                    var randomNumber = Math.floor(Math.random() * 100) + 1;

                    if (cards.length > 0) {
                        if (cards.includes(randomNumber)) {
                            i--;
                        } else {
                            cards.push(randomNumber);
                        }
                    } else {
                        cards.push(randomNumber);
                    }
                }

                //duplicate cards for matching values
                cards = cards.flatMap(cards => [cards, cards]);

                //shuffle cards
                cards.sort(() => Math.random() - 0.5);

                //push ramdom cards to main variable of cards
                for (let i = 0; i < cards.length; i++) {

                    this.randomCards.push({
                        'index_id': i,
                        'card_id': cards[i],
                        'opened': false,
                        'freezed': false
                    })
                }

                console.log(this.randomCards)
                this.startTimer()

                this.$refs.backgroundMusic.pause();

                this.debouncedSaveSession();
            }

        },
        flipCard(index) {
            //check card if freezed
            if (this.randomCards[index].freezed == false && this.verifying == false) {

                //check card if opened
                if (this.randomCards[index].opened == false) {

                    //set selected card to be opened
                    this.randomCards[index].opened = true;
                    this.$refs.flipCardSound.play();

                    //check if firstCard has value
                    if (this.firstCard == null) {

                        //set aside card
                        this.firstCard = this.randomCards[index];

                        this.verifying = false;
                        console.log(this.firstCard)

                        this.debouncedSaveSession();

                    } else {

                        var firstCardIndex = this.firstCard.index_id;

                        //compare card from other card opened
                        if (this.firstCard.card_id == this.randomCards[index].card_id) {

                            this.$refs.correctSound.play();
                            this.matchedCards++;

                            // perform card freeze    
                            const performFreeze = (firstCardIndex) => {
                                this.randomCards[index].freezed = true;
                                this.randomCards[firstCardIndex].freezed = true;
                            };

                            // add delaying freeze effect
                            setTimeout(() => performFreeze(firstCardIndex), 300);


                            // compare matched cards to trigger reset
                            if (this.matchedCards == (this.cards / 2)) {
                                // game finished
                                this.$refs.finishGameSound.play();

                                setTimeout(() => this.formSubmit(), 200);
                            }

                            this.firstCard = null;
                            this.verifying = false;

                            this.debouncedSaveSession();

                        } else {
                            this.$refs.errorFlipCardSound.play();
                            this.verifying = true;
                            // set timer to set the card back to front
                            this.delayedAction(this.firstCard.index_id, index)

                            this.debouncedSaveSession();

                        }

                    }

                    //flip count
                    this.count++;

                }
            }
            // if(this.randomCards[index].opened)
            // this.showCard = !this.showCard; 
            // // alert(this.showCard)

            // this.debouncedSaveSession();
        },

        debouncedSaveSession() {
            // Clear the previous timeout to avoid multiple invocations
            clearTimeout(this.debounceSaveSession);

            // Set a new timeout for 1 second (adjust as needed)
            this.debounceSaveSession = setTimeout(() => {
                this.saveSession();
            }, 1000); // Adjust the timeout duration as needed
        },

        delayedAction(firstCard, secondCard) {

            console.log(firstCard)

            // Set the duration of the timer in milliseconds (.7 seconds)
            setTimeout(() => performAction(firstCard, secondCard), 700);

            // Function to be executed after the timer
            const performAction = (firstCard, secondCard) => {

                console.log(firstCard);
                this.randomCards[firstCard].opened = false;
                this.randomCards[secondCard].opened = false;

                this.firstCard = null;
                this.verifying = false;

            }

            this.debouncedSaveSession();
        },
        formSubmit() {

            axios.post('/postplayer', {
                name: this.playerName,
                seconds: this.timerSeconds,
                difficulty: this.difficulty,
                flips: this.count,
            })
            .then((response) => {
                var data = response.data;
                if (data != null) {
                    this.totalScore = data['points'];
                    this.showModal = true;

                } else {
                    console.log('error')
                }
            })
            .catch((error) => {
                console.log(error);
            });

        },
        closeModal() {
            this.resetGame();
        },
        resetGame() {

            const backgroundMusic = this.$refs.backgroundMusic;
            backgroundMusic.volume = 0.5; // Set volume to 50%
            backgroundMusic.play();

            if (this.difficulty == 1) {
                this.$refs.easyModeSound.pause();
            } else if (this.difficulty == 2) {
                this.$refs.averageModeSound.pause();
            } else if (this.difficulty == 3) {
                this.$refs.hardModeSound.pause();
            } else if (this.difficulty == 5) {
                this.$refs.impossibleModeSound.pause();
            }

            this.count = 0;
            this.active = true;
            this.showCard = false;
            this.difficulty = null;
            this.cards = 0;
            this.randomCards = [];

            this.firstCard = null;
            this.verifying = false;
            this.matchedCards = 0;
            this.playerName = 'Player';
            clearInterval(this.timerInterval);
            this.timerSeconds = 0;
            this.totalScore = 0;
            this.timerInterval = null;
            this.showModal = false;
            this.getRankings();

            axios.post('/clearSession')

        },
        startTimer() {
            // Set interval to update the timer every second
            this.timerInterval = setInterval(() => {
                this.timerSeconds++;
            }, 1000);
        },
        formatTime(time) {
            return time < 10 ? `0${time}` : `${time}`;
        },
        limitInput() {
            // Limit the input to 10 characters
            this.playerName = this.playerName.slice(0, 10);
        }
    },
    beforeDestroy() {
        // Clear the interval when the component is destroyed to prevent memory leaks
        clearInterval(this.timerInterval);
    },
};
</script>
