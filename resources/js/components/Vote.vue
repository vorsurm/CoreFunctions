<template>
    <div>
        <a :title="title('up')" class="vote-up" :class="classes" @click.prevent="voteUp" >
           <i class="fas fa-caret-up fa-3x"> </i>
        </a>

        <span class="votes-count"> {{ count }} </span>

        <a :title="title('down')" class="vote-down" :class="classes" @click.prevent="voteDown">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>

        <favorite v-if="name == 'question'" :question="model"> </favorite>
        
        <accept v-else :answer="model"> </accept>
        
    </div>
</template>

<script>
import Favorite from './Favorite';
import Accept from './Accept';

export default {
    props: ['model', 'name'],
    data(){
        return{
            count: this.model.votes_count || 0,
            id: this.model.id
        }
    },
    components:{
        Favorite,
        Accept
    },
    computed:{
        classes(){
            return this.SignedIn ? '' : 'off';
        },
        endpoint(){
            return `/${this.name}s/${this.id}/vote`;
        }
       
    },
    methods:{
         title(voteType){

            let titles = {
                up: `This ${this.name} is useful`,
                down: `This ${this.name} is not useful`
            }
            return titles[voteType];
        },
        voteUp(){
            this._vote(1);
        },
        voteDown(){
            this._vote(-1);
        },
        _vote(vote){
            if(!this.SignedIn){
                this.$toast.warning(`Please login to vote the ${this.name}`,'Warning',{
                    timeout: 3000,
                    position: 'bottomLeft'
                });
            }
            axios.post(this.endpoint, {vote})
            .then(res =>{
                this.$toast.success(res.data.message, "Success", {
                    timeout:3000,
                    position: 'bottomLeft'
                })

                this.count = res.data.voteCount;
            });
        }
    }
}
</script>