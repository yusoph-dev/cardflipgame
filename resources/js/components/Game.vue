
<template>

    
    <div id="my-container">
        <header class="p-3 bg-dark text-white">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img class="bi me-2" width="32" height="32" role="img" aria-label="Bootstrap" :src="'images/pokeball.png'">
                    </a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="#" class="nav-link px-2 text-yellow"></a></li>
                    <!-- <li><a href="#" class="nav-link px-2 text-white">Features</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">Pricing</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">FAQs</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">About</a></li> -->
                    </ul>

                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li style="border: 3px solid transparent; font-weight: 600;"><span class="nav-link px-2 text-white">NO. OF TURNS : {{ count }}</span></li>
                    </ul>
                    </form>

                    <div class="text-end">
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li style="border: 3px solid transparent; font-weight: 600;"><button @click="resetGame" class="nav-link px-2 bg-dark text-white">RESET</button></li>
                        <li style="border: 3px solid #CC0000; font-weight: 600;"><span class="nav-link px-4 text-white" >{{ formattedTime }}</span></li>
                    </ul>
                    </div>
                </div>
            </div>
        </header>

        <div class="container" v-if="difficulty == null">
            <div class="row p-4">
                <h2>Player Name</h2>
                <div class="btn-group btn-group-toggle form-group" data-toggle="buttons">
                    <input type="text" class="form-control" v-model="playerName">
                </div>
            </div>
            <div class="row p-4">
                <h2>Select Difficulty</h2>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <button @click="setDifficulty(1)" type="button" class="btn btn-success btn-lg" >EASY</button>
                    <button @click="setDifficulty(2)" type="button" class="btn btn-primary btn-lg" >AVERAGE</button>
                    <button @click="setDifficulty(3)" type="button" class="btn btn-warning btn-lg text-dark" >HARD</button>
                    <button @click="setDifficulty(5)" type="button" class="btn btn-danger btn-lg" >IMPOSSIBLE</button>
                </div>
            </div>
            <div class="row p-4" v-if="(rankings.length > 0)">
                <h2>Player Rankings</h2>
                <div class="container">
                    <table class="table table-dark table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">Name</th>
                                <th class="text-center" scope="col">Time</th>
                                <th class="text-center" scope="col">Difficulty</th>
                                <th class="text-center" scope="col">Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(player, index) in rankings" :key="player.id">
                                <th class="text-center" scope="row">{{ index + 1 }}</th>
                                <td class="text-center">{{ player.name }}</td>
                                <td class="text-center">{{ player.seconds }}</td>
                                <td class="text-center">
                                    <span v-if="player.difficulty == 1" class="badge bg-success">EASY</span>
                                    <span v-if="player.difficulty == 2" class="badge bg-primary">AVERAGE</span>
                                    <span v-if="player.difficulty == 3" class="badge bg-warning text-dark">HARD</span>
                                    <span v-if="player.difficulty == 5" class="badge bg-danger">IMPOSSIBLE</span>
                                </td>
                                <td class="text-center">{{ player.points  }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="container" v-if="difficulty != null">
            <div class="row" >
                <template v-for="(item, index) in randomCards" :key="item">

                    <div class="flip-card p-1" v-bind:class="{'col-md-3': (difficulty == 1), 'col-md-2': (difficulty == 2 ), 'col-md-1': (difficulty > 2 && difficulty < 6)}" v-on:click="flipCard(index)" >
                        <div class="card card-inner" v-bind:class="{flipped: item.opened}" > 
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
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalCenterTitle">CONGRATULATIONS</h4>
                </div>
                <div class="modal-body">
                    <h3>{{ playerName }}</h3>
                    <h3>Total score is: {{ totalScore }}</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModal">RESET</button>
                </div>
            </div>
        </div>

        
        <footer class="d-flex bg-dark text-white flex-wrap justify-content-between align-items-center py-3 ">
            <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
            </a>
            <span class="text-muted">© 2023 Yusoph Flip Card MINI GAME</span>
            </div>

            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"></use></svg></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"></use></svg></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"></use></svg></a></li>
            </ul>
        </footer>

         <!-- Background Music -->
        <audio ref="backgroundMusic" controls autoplay loop>
            <source :src="backgroundMusicSrc" type="audio/mp3">
            Your browser does not support the audio element.
        </audio>

        <!-- Click Sound -->
        <audio ref="flipCardSound">
            <source :src="flipSoundSrc" type="audio/mp3">
            Your browser does not support the audio element.
        </audio>
    </div>
</template>

<script>
    export default { 
        el: '#my-container',
        name: "app", 
        data() { 
            return { 
                backgroundMusicSrc: "/music/bg.mp3",
                flipSoundSrc: "/music/cardflip.mp3",
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
            this.getRankings();
        },
        methods: { 
            getRankings(){
                axios.get('/rankings')
                .then(response => {
                    this.rankings = response.data.rankings;
                    this.playerName = 'Player'+this.rankings.length;
                })
                .catch(error => {
                    console.error('Error fetching rankings:', error);
                });
            },
            setDifficulty(selected){

                if(this.playerName != null){

                    this.difficulty = selected;

                    if(this.difficulty == 1){
                        this.cards = (4 * 2);
                    }
                    
                    if(this.difficulty == 2){
                        this.cards = (6 * 3);
                    }
                    
                    if(this.difficulty == 3){
                        this.cards = (6 * 8);
                    }

                    if(this.difficulty == 5){
                        this.cards = (12 * 8);
                    }

                    var cards = [];

                    //generate cards available numbers
                    for (let i = 0; i < (this.cards / 2); i++) {

                        var randomNumber = Math.floor(Math.random() * 100) + 1;

                        if(cards.length > 0){
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
                    for(let i = 0; i < cards.length; i++){

                        this.randomCards.push({
                            'index_id' : i,
                            'card_id' : cards[i],
                            'opened' : false,
                            'freezed' : false
                        })
                    }

                    console.log(this.randomCards)
                    this.startTimer()
                }

            },
            flipCard(index){ 
                //check card if freezed
                if(this.randomCards[index].freezed == false && this.verifying == false){
                    
                    //check card if opened
                    if(this.randomCards[index].opened == false){

                        //set selected card to be opened
                        this.randomCards[index].opened = true;
                        this.$refs.flipCardSound.play();

                        //check if firstCard has value
                        if(this.firstCard == null){

                            //set aside card
                            this.firstCard = this.randomCards[index];
                            
                            this.verifying = false;
                            console.log(this.firstCard)

                        }else{

                            //compare card from other card opened
                            if(this.firstCard.card_id == this.randomCards[index].card_id){

                                this.matchedCards++;
                                
                                //compare matched cards to trigger reset
                                if(this.matchedCards == (this.cards / 2)){
                                    // this.resetGame();
                                    
                                    setTimeout(() => this.formSubmit(), 200);
                                }else{

                                    var firstCardIndex = this.firstCard.index_id;

                                    // perform card freeze    
                                    const performFreeze = (firstCardIndex) => {
                                        this.randomCards[index].freezed = true;
                                        this.randomCards[firstCardIndex].freezed = true;
                                    };

                                    // add delaying freeze effect
                                    setTimeout(() => performFreeze(firstCardIndex), 300);
                                }

                                this.firstCard = null;
                                this.verifying = false;

                            }else{
                                
                                this.verifying = true;
                                // set timer to set the card back to front
                                this.delayedAction(this.firstCard.index_id, index)

                            }

                        }

                        //flip count
                        this.count++;
                    }
                }
                // if(this.randomCards[index].opened)
                // this.showCard = !this.showCard; 
                // // alert(this.showCard)
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

            }, 
            formSubmit() {  
                
                axios.post('/postplayer', {  
                    name: this.playerName,  
                    seconds: this.timerSeconds,
                    difficulty: this.difficulty,  
                })  
                .then((response) => {  
                    var data = response.data;
                    if(data != null){
                        this.totalScore = data['points'];
                        this.showModal = true;
                    }else{
                        console.log('error')
                    }
                })  
                .catch((error) => {  
                    console.log(error);  
                });  

                
                
            },  
            closeModal(){
                this.resetGame();
            },
            resetGame(){
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
        },
        beforeDestroy() {
            // Clear the interval when the component is destroyed to prevent memory leaks
            clearInterval(this.timerInterval);
        }, 
    }; 
</script>
 