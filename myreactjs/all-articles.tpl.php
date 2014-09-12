<div id="content"></div>
<script type="text/jsx">
            /** @jsx React.DOM */

            var ContentBox = React.createClass({
                loadContentsFromServer: function() {
                    jQuery.ajax({
                        url: this.props.url,
                        dataType: 'json',
                        success: function(data) {
                            this.setState({data: data})
                        }.bind(this)
                    })
                },

                getInitialState: function() {
                    return {data: []}
                },
                componentWillMount: function() {
                    this.loadContentsFromServer()
                    setInterval(this.loadContentsFromServer, this.props.pollInterval)
                },
                render: function() {

                    return (
                        <div className='contentBox'>
                            <h1>Contents</h1>
                            <ContentList data={this.state.data} />

                        </div>
                    )
                }
            })

            var ContentList = React.createClass({

                render: function() {
                    var commentNodes = this.props.data.map(function(content) {
                                return <Comment title={content.title} body={content.Body} image={content.Image}></Comment>
                        })
                    return (
                        <div className='contentList'>
                            {commentNodes}
                        </div>
                    )
                }
            })



            var Comment = React.createClass({
                render: function() {
                    return (
                        <div className='comment'>
                            <h2 className='commentAuthor'>
                                {this.props.title}
                            </h2>
                             <img src={this.props.image}/>
                             {this.props.body}

                        </div>
                    )
                }
            })

            React.renderComponent(
                <ContentBox url='/nodes2/json' pollInterval={2000}/>,
                document.getElementById('content')
            )
</script>