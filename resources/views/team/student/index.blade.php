@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-students', $team) }}
@endsection
@section('style')
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
@endsection
@section('content')
    <div id="students">
        <v-app>
            <v-content>
                <v-container>
                    <v-card>
                        <v-row
                                class="pa-4"
                                justify="space-between"
                        >
                            <v-col cols="5"
                                   class="overflow-y-auto"
                                   style="max-height: 60vh">
                                <v-treeview
                                        :active.sync="active"
                                        :items="users"
                                        :open.sync="open"
                                        activatable
                                        color="warning"
                                        open-on-click
                                        transition
                                >
                                    <template v-slot:prepend="{ item, active }">
                                        <v-icon v-if="!item.children">mdi-account</v-icon>
                                    </template>
                                </v-treeview>
                            </v-col>

                            <v-divider vertical></v-divider>

                            <v-col
                                    class="d-flex text-center"
                            >
                                <v-scroll-y-transition mode="out-in">
                                    <div
                                            v-if="!selected"
                                            class="title grey--text text--lighten-1 font-weight-light"
                                            style="align-self: center;"
                                    >
                                        Select a User
                                    </div>
                                    <v-card
                                            v-else
                                            :key="selected.id"
                                            class="pt-6 mx-auto"
                                            min-width="350px"
                                            flat
                                    >
                                        <v-card-text>
                                            <v-avatar
                                                    v-if="avatar"
                                                    size="88"
                                            >
                                                <v-img
                                                        :src="'/uploads/avatars/'+ selected.avatar"
                                                        class="mb-6"
                                                ></v-img>
                                            </v-avatar>
                                            <h3 class="headline mb-2">
                                                @{{ selected.name }}
                                            </h3>
                                            <div class="blue--text mb-2">@{{ selected.email }}</div>
                                            <div class="blue--text mb-2 subheading font-weight-bold">@{{ selected.phone }}</div>
                                            <div class="blue--text">@{{ selected.age }} years old</div>
                                        </v-card-text>
                                        <v-divider></v-divider>

                                        <v-card-text>
                                                <div class="blue--text mb-2">Company - @{{ selected.company }}</div>
                                                <div class="blue--text mb-2">Position - @{{ selected.position }}</div>
                                                <div class="blue--text mb-2">Experience - @{{ selected.experience }} years</div>
                                                <div class="blue--text mb-2">Education - @{{ selected.education.name }}</div>
                                                <div class="blue--text mb-2">Speciality - @{{ selected.education.speciality }}</div>
                                                <div class="blue--text mb-2">English lvl - @{{ selected.english_lvl }}</div>
                                                <div class="blue--text mb-2">Introductory score - @{{ selected.introductory_score }}</div>
                                        </v-card-text>
                                    </v-card>
                                </v-scroll-y-transition>
                            </v-col>
                        </v-row>
                    </v-card>

                </v-container>
            </v-content>
        </v-app>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script>
        const avatars = [
            '?accessoriesType=Blank&avatarStyle=Circle&clotheColor=PastelGreen&clotheType=ShirtScoopNeck&eyeType=Wink&eyebrowType=UnibrowNatural&facialHairColor=Black&facialHairType=MoustacheMagnum&hairColor=Platinum&mouthType=Concerned&skinColor=Tanned&topType=Turban',
            '?accessoriesType=Sunglasses&avatarStyle=Circle&clotheColor=Gray02&clotheType=ShirtScoopNeck&eyeType=EyeRoll&eyebrowType=RaisedExcited&facialHairColor=Red&facialHairType=BeardMagestic&hairColor=Red&hatColor=White&mouthType=Twinkle&skinColor=DarkBrown&topType=LongHairBun',
            '?accessoriesType=Prescription02&avatarStyle=Circle&clotheColor=Black&clotheType=ShirtVNeck&eyeType=Surprised&eyebrowType=Angry&facialHairColor=Blonde&facialHairType=Blank&hairColor=Blonde&hatColor=PastelOrange&mouthType=Smile&skinColor=Black&topType=LongHairNotTooLong',
            '?accessoriesType=Round&avatarStyle=Circle&clotheColor=PastelOrange&clotheType=Overall&eyeType=Close&eyebrowType=AngryNatural&facialHairColor=Blonde&facialHairType=Blank&graphicType=Pizza&hairColor=Black&hatColor=PastelBlue&mouthType=Serious&skinColor=Light&topType=LongHairBigHair',
            '?accessoriesType=Kurt&avatarStyle=Circle&clotheColor=Gray01&clotheType=BlazerShirt&eyeType=Surprised&eyebrowType=Default&facialHairColor=Red&facialHairType=Blank&graphicType=Selena&hairColor=Red&hatColor=Blue02&mouthType=Twinkle&skinColor=Pale&topType=LongHairCurly',
        ]

        new Vue({
            el:'#students',
            vuetify: new Vuetify(),
            data: () => ({
                offsetTop: 0,
                active: [],
                avatar: null,
                open: [],
                users: {!! json_encode($team->getApiStudents())!!}
            }),

            computed: {
                onScroll (e) {
                    this.offsetTop = e.target.scrollTop
                },
                items () {
                    return [
                        {
                            name: 'Users',
                            children: this.users,
                        },
                    ]
                },
                selected () {
                    if (!this.active.length) return undefined

                    const id = this.active[0]

                    return this.users.find(user => user.id === id)
                },
            },

            watch: {
                selected: 'randomAvatar',
            },

            methods: {
                randomAvatar () {
                    this.avatar = avatars[Math.floor(Math.random() * avatars.length)]
                },
            },
        })
    </script>
@endsection
