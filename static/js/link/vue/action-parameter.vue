<template>
<div class="form-group">
	<label for="" class="col-sm-2">{{config.title}}</label>
	<div class="col-sm-10">
		<input v-if="['select', 'radio', 'checkbox'].indexOf(config.type) == -1" :type="config.type ? config.type : 'text'" class="form-control"
			:value="value"
			@input="change($event.target.value)"
			:placeholder="config.placeholder ? config.placeholder : '[' + config.title + ']'">
		<div v-else-if="config.type == 'radio'" class="">
			<label class="radio-inline" v-for="(t, v) in config.list">
				<input type="radio" :name="radioName" :value="v" @change="change($event.target.value)" :checked="value == v"> {{t}}
			</label>
			<div class="clearfix"></div>
		</div>
		<div v-else-if="config.type == 'checkbox'" class="">
			<label class="checkbox-inline" v-for="(t, v) in config.list">
				<input type="checkbox" :value="v" @change="multi($event.target)" :checked="value instanceof Array && value.indexOf(v) > -1"> {{t}}
			</label>
			<div class="clearfix"></div>
		</div>
		<select v-else="config.type == 'select'" class="form-control" @change="select($event.target)" :multiple="config.multiple">
			<option :value="v" v-for="(t, v) in config.list" :selected="value instanceof Array ? value.indexOf(v) > -1 : v == value">{{t}}</option>
		</select>
	</div>
	<div class="clearfix"></div>
</div>
</template>

<script>
	export default {
		props: ['settings', 'value'],
		data() {
			return {
				radioName: Math.random(),
			};
		},
		computed: {
			checked() {
				return this.value ? [].concat(this.value) : [];
			},
			config() {
				let res = typeof this.settings == 'string' ? {
					title: this.settings,
					type: 'text',
					value: ''
				} : this.settings;

				if (res.value && (res.type == 'checkbox' || res.multiple) && !(res.value instanceof Array))
					res.value = [].concat(res.value);

				return res;
			}
		},
		methods: {
			change(v) {
				if (this.config.type == 'number')
					v = Number(v);
				this.$emit('input', v);
			},
			multi(o) {
				var i = this.checked.indexOf(o.value);
				if (i > -1) this.checked.splice(i, 1);
				if (o.checked) this.checked.push(o.value);
				this.$emit('input', this.checked);
			},
			select(o) {
				let values = [...o.options].filter(option => option.selected).map(option => option.value);
				let value = o.multiple ? values : values[0];
				this.$emit('input', value);
			}
		}

	};
</script>