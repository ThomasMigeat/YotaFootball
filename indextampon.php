
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />


<title>Youtube Like & Dislike System</title>
<style>
body
  width 100%
  height 100%
  margin 0
  padding 0
  overflow hidden
  backgound #eff1f1
  
  .container
    width 50vh
    height 20vh
    background #f9f9f9
    border-radius 10vh
    box-shadow 0px 10px 30px 0px rgba( 0, 0, 0, 0.25 )
    position absolute
    top 50%
    left 50%
    transform translate( -50%, -50% )
    
    .line
      width 70%
      height 1px
      background #7ED320
      position absolute
      top 50%
      left 50%
      transform translate( -50%, -50% )
      transition all 0.5s cubic-bezier( 0.455, 0.030, 0.515, 0.955 )
      
    .knob
      width 15vh
      height 15vh
      background #7ED320
      border-radius 50%
      position absolute
      top 50%
      left 21%
      transform translate( -50%, -50% )
      transition all 0.5s cubic-bezier( 0.175, 0.885, 0.700, 1.200 )
      &:after
        content ''
        font-family FontAwesome
        font-size 7vh
        color #fff
        text-align center
        display block
        width 50%
        height 50%
        position absolute
        top 50%
        left 50%
        transform translate( -50%, -50% )
      
    &.like
      .line
        background #7ED320
      .knob
        background #7ED320
        left 79%
        &:after
          content '\f164'

    &.dislike
      .line
        background #F36D48
      .knob
        background #F36D48
        left 21%
        &:after
          content '\f165'
</style>
</head>
<body>

	<script>
class Switch {
  constructor( element ) {
    console.clear()
    
    this.element = element
    this.like = true
    
    this.update()
    this.init()
  }
  
  init() {
    this.element.querySelector( '.knob' ).addEventListener( 'click', () => {
      this.like = !this.like
      this.update()
    } )
  }
  
  update() {
    if ( this.like ) {
      this.element.classList.remove( 'dislike' )
      this.element.classList.add( 'like' )
    } else {
      this.element.classList.remove( 'like' )
      this.element.classList.add( 'dislike' )
    }
  }
}

const knobContainer = document.querySelector( '.container' )
new Switch( knobContainer )

</script>

.container
  .line
  .knob


</body>
</html>


